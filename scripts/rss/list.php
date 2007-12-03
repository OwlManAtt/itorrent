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

    $rss_items = $feed->grabItems();

    $ITEMS = array();
    foreach($rss_items as $item)
    {
        $ITEMS[] = array(
            'title' => $item->getTitle(),
            'url' => $item->getLink(),
            'datetime' => $item->getPubdate(),
        );
    } // end item reformat loop

    $renderer->assign('feed',$FEED);
    $renderer->assign('feed_menu',$FEED_MENU);
    $renderer->assign('items',$ITEMS);
    $renderer->display('rss/list.tpl');
} // no errors

?>
