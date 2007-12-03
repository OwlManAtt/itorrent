<?php
class RSSHighlight
{
    protected $db;
    protected $highlights = array();

    public function __construct($db)
    {
        $this->db = $db;

        $highlights = new RSSHighlight_Row($this->db);
        $highlights = $highlights->findBy(array());
        
        foreach($highlights as $highlight)
        {
            $this->highlights[] = array(
                'regexp' => $highlight->getHighlightPreg(),
                'type' => $highlight->getHighlightType(),
            );
        }
    } // end __construct

    public function checkValue($value)
    {
        foreach($this->highlights as $highlight)
        {
            if(preg_match($highlight['regexp'],$value) == true)
            {
                return $highlight['type'];
            }
        } // end loop

        return false;
    } // end checkTitle
}  // end RSSHighlight

class RSSHighlight_Row extends ActiveTable
{
    protected $table_name = 'rss_highlight';
    protected $primary_key = 'rss_highlight_id';

} // end RSSHighlight

?>
