<?php
$ERRORS = array();

$feed_id = stripinput($_GET['feed_id']);

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
                $style = 'font-weight: bold; font-size: large;';
                $icon = 'blue_chevron_right.png';
            }
            elseif($highlight == 'minimize')
            {
                $style = 'color: gray; font-size: small;';
            }

            $ITEMS[] = array(
                'title' => $item->getTitle(),
                'url' => $item->getLink(),
                'datetime' => $item->getPubdate(),
                'style' => $style,
                'icon' => $icon,
            );
        }
    } // end item reformat loop

    $renderer->assign('feed',$FEED);
    $renderer->assign('feed_menu',$FEED_MENU);
    $renderer->assign('items',$ITEMS);
    $renderer->display('rss/list.tpl');
} // no errors

?>
