<?php

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
