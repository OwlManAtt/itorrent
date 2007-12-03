<?php

class RSSFeed_Item extends Getter
{
    protected $title;
    protected $link;
    protected $category;
    protected $description;
    protected $guid;
    protected $pubdate;

    public function __construct($attributes)
    {
        foreach($attributes as $key => $value)
        {
            $this->$key = $value;
        } // end loop
    } // end construct
} // end RSSFeed_Item

?>
