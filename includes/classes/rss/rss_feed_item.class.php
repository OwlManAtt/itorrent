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
            $this->$key = trim($value);
        } // end loop
    } // end construct

    public function getTitle()
    {
        return str_replace(array("\xe2","\x80","\x8b"),null,$this->title);
    } // end getTitle

} // end RSSFeed_Item

?>
