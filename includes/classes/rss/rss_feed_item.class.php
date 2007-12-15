<?php
/**
 * Represents an item in an RSS feed. 
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
