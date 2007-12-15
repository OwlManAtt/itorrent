<?php
/**
 * Parent for the rTorrent settings/torrent/etc classes. 
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

class rTorrent extends Getter
{
    protected function duration($secs) 
    { 
        $vals = array(
            'w' => (int) ($secs / 86400 / 7), 
            'd' => $secs / 86400 % 7, 
            'h' => $secs / 3600 % 24, 
            'm' => $secs / 60 % 60, 
            's' => $secs % 60
        ); 

        $ret = array(); 

        $added = false; 
        foreach ($vals as $k => $v) { 
            if ($v > 0 || $added) { 
                $added = true; 
                $ret[] = $v . $k; 
            } 
        } 

        return join(' ', $ret); 
    } // end duration 
} // end rTorrent
?>
