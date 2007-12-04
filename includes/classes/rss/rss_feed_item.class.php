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

    public function getLeanTitle()
    {
        $title = $this->getTitle();
        
        // Try and remove the group tag.
        if(preg_match('/^\[([A-Z0-9\s-_]{1,})\]/i',$title,$GROUP) == true)
        {
            $title = preg_replace('/^\[[A-Z0-9\s-_]{1,}\](_|\s)?/i',null,$title);
        }

        // Strip the filetype out
        preg_match('/\.([a-z0-9]{2,4})$/i',$title,$TYPE);
        $title = preg_replace('/\.[a-z0-9]{2,4}$/i',null,$title);

        // Try and remove the CRC
        $title = preg_replace('/\[[A-F0-9]{8,}\]/',null,$title);

        // Remove quality tags.
        $title = preg_replace('/\[(h264|xvid)\]/i',null,$title);

        return array(
            'title' => $title,
            'group' => $GROUP[1],
            'filetype' => $TYPE[1],
        );
    } // end getLeanTitle

} // end RSSFeed_Item

?>
