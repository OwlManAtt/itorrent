<?php
/**
 * Pause/restart torrents. 
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


$hash_id = stripinput($_POST['hash_id']);
$torrent = Torrent::findOneByHash($APP_CONFIG['rpc_uri'],$hash_id);

if($torrent == null)
{
    draw_errors('Invalid torrent hash specified.');
}
else
{
    $verb = '';
    if($torrent->getActive() == true) 
    {
        $verb = 'stopped';
        $torrent->pause($APP_CONFIG['rpc_uri']);
    }
    else
    {
        $verb = 'started';
        $torrent->start($APP_CONFIG['rpc_uri']);
    }

    $_SESSION['torrents_alert'] = "{$torrent->getTitle()} was $verb.";
    
    if($UI_TYPE == 'iphone')
    {
        redirect(null,null,"torrents/#torrent_{$torrent->getHash()}");
    }
    else
    {
        redirect('torrents');
    }
} // end change status

?>
