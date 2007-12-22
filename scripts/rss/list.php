<?php
/**
 * RSS reader. 
 *
 * This file is part of 'iTorrent'.
 *
 * 'iTorrent' is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 3 of the License,
 * or (at your option) any later version.
 * 
 * 'iTorrent' is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE.  See the GNU General Public
 * License for more details.
 * 
 * You should have received a copy of the GNU General
 * Public License along with 'iTorrent'; if not,
 * write to the Free Software Foundation, Inc., 51
 * Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @author Nicholas 'Owl' Evans <owlmanatt@gmail.com>
 * @copyright Nicolas Evans, 2007
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @package iTorrent
 * @version 1.0.0
 **/


$ERRORS = array();

$feed_id = stripinput($_REQUEST['feed_id']);

$feed = new RSSFeed($db);

if($feed_id == null)
{
    $feed = $feed->findOneByDefault('Y');
}
else
{
    $feed = $feed->findOneByRssFeedId($feed_id);
}

if($feed == null)
{
    $ERRORS[] = 'RSS feed not found.';
}

if(sizeof($ERRORS) > 0)
{
    draw_errors($ERRORS);
}
else
{
    // Build a hash of torrents being downloaded. The RSS feed's items will
    // be compared against this hash, and any matching item are surpressed.
    $torrents = Torrent::findByStatus($APP_CONFIG['rpc_uri'],'all');
    
    $TORRENTING = array();
    foreach($torrents as $torrent)
    {
        $TORRENTING[] = $torrent->getTitle();

        /*
        print "<pre>\n";
            var_dump($torrent->getTitle());
            print ' - ';
            print mb_detect_encoding($torrent->getTitle());
        print "</pre>\n";
        */
    } // end array
    
    // Get the list of feeds for the dropdown menu.
    $feed_list = new RSSFeed($db);
    $feed_list = $feed_list->findBy(array());
    
    $FEED_MENU = array();
    foreach($feed_list as $f)
    {
        $FEED_MENU[$f->getRssFeedId()] = $f->getFeedTitle();
    } // end feed loop

    $FEED = array(
        'id' => $feed->getRssFeedId(),
        'name' => $feed->getFeedTitle(),
    );

    $rss_highlighter = new RSSHighlight($db);
    $rss_items = $feed->grabItems();

    $i = 1;
    $ITEMS = array();
    foreach($rss_items as $item)
    {
        // Surpress things being downloaded/seeded already.
        if(in_array($item->getTitle(),array_values($TORRENTING)) == false)
        {
            /*
            print "<pre>\n";
                var_dump($item->getTitle());
                print ' - ';
                print mb_detect_encoding($item->getTitle());
            print "</pre>\n";
            */

            $highlight = $rss_highlighter->checkValue($item->getTitle());
            $style = '';
            $icon = '';
            if($highlight == 'important')
            {
                if($UI_TYPE == 'iphone')
                {
                    $style = 'color: green;';
                }
                else
                {
                    $style = 'font-weight: bold; font-size: large;';
                }
                
                $icon = 'blue_chevron_right.png';
            }
            elseif($highlight == 'minimize')
            {
                $style = 'color: gray; font-size: small;';
            }
            $TorrentMeta = new TorrentMeta($db);
            $ITEMS[] = array(
                'internal_id' => $i,
                'title' => $item->getTitle(),
                'title_details' => $item->getLeanTitle(),
                'url' => $item->getLink(),
                'datetime' => $item->getPubdate(),
                'style' => $style,
                'icon' => $icon,
                'info_hash' => $TorrentMeta->cacheTorrent($item->getLink()),
            );

            $i++;
        }
    } // end item reformat loop

    $renderer->assign('feed',$FEED);
    $renderer->assign('feed_menu',$FEED_MENU);
    $renderer->assign('items',$ITEMS);
    $renderer->display('rss/list.tpl');
} // no errors

?>
