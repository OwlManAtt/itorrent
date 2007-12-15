<?php
/**
 * Add a torrent via URL.
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


switch($_REQUEST['state'])
{
    default:
    {
        $renderer->display('torrents/add.tpl');

        break;
    } // end default

    case 'add':
    {
        $ERRORS = array();
        
        if($_POST['torrent']['uri'] == null)
        {
            $ERRORS[] = 'No torrent URI specified.';
        }

        if(sizeof($ERRORS) > 0)
        {
            draw_errors($ERRORS);
        }
        else
        {
            $start_immediately = true;
            if($_POST['torrent']['pause'] == 'false')
            {
                $start_immediately = false;
            }
            
            $torrent = Torrent::create($APP_CONFIG['rpc_uri'],$_POST['torrent']['uri'],$start_immediately);

            $_SESSION['torrents_alert'] = 'Torrent added. It should show up soon...maybe.';

            if($UI_TYPE == 'iphone')
            {
                redirect('rss-feeds');
            }
            else
            {
                redirect('torrents');
            }
        } // end no errors

        break;
    } // end add
    
} // end switch
?>
