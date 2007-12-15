<?php
/**
 * RSS feed from the config DB.
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


class RSSFeed extends ActiveTable
{
    protected $table_name = 'rss_feed';
    protected $primary_key = 'rss_feed_id';

    public function grabItems()
    {
        // Load up the RSS feed and show it.
        $rss = simplexml_load_file(rawurlencode($this->getFeedUrl()),null,LIBXML_NOCDATA);

        $ITEMS = array();
        foreach($rss->channel->item as $item)
        {
            $link = (string)$item->link;
            $link = $this->resolveLink($link);
            
            $DATA = array(
                'guid' => (string)$item->guid,
                'title' => (string)$item->title,
                'link' => $link, 
                'pubdate' => date('Y-m-d H:i',strtotime((string)$item->pubDate)),
                'category' => (string)$item->category,
                'description' => (string)$item->description,
            );

            $rss_item = new RSSFeed_Item($DATA);
            $ITEMS[] = $rss_item;
        } // end RSS item loop
        
        return $ITEMS;
    } // end grabItems

    protected function resolveLink($url)
    {
        if(preg_match('/^http:\/\/((www|sukebe).)?nyaatorrents\.org\/\?page=torrentinfo&tid=([0-9]+)/i',$url,$ID) == true)
        {
            return "http://{$ID[1]}nyaatorrents.org/?page=download&tid={$ID[3]}";
        }

        return $url;
    } // end resolvelink
} // end RSS

?>
