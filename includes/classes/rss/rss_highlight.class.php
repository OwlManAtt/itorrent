<?php
/**
 * Highlights for the RSS feeds. 
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
