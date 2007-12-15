<?php
/**
 *  Show torrents and torrent status.
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


$torrents = Torrent::findByStatus($APP_CONFIG['rpc_uri'],'all');

$TORRENTS = array(
    'complete' => array(),
    'incomplete' => array(),
);

foreach($torrents as $torrent)
{
    $key = (($torrent->getComplete() == true) ? 'complete' : 'incomplete');

    $TORRENTS[$key][] = array(
        'hash' => $torrent->getHash(),
        'title' => $torrent->getTitle(),
        'size' => array(
            'total' => $torrent->getFormattedTotalBytes(),
            'downloaded' => $torrent->getFormattedBytesComplete(),
        ),
        'rate' => array(
            'up' => $torrent->getFormattedUploadSpeed(),
            'down' => $torrent->getFormattedDownloadSpeed(),
        ),
        'active' => $torrent->getActive(),
        'status' => $key,
        'percent_complete' => $torrent->getPercentComplete(),
        'eta' => $torrent->getEstimatedTimeLeft(),
        'ratio' => $torrent->getRatio(),
    );
} // end torrent reformatting loop

if(isset($_SESSION['torrents_alert']) == true)
{
    $renderer->assign('alert',$_SESSION['torrents_alert']);
    unset($_SESSION['torrents_alert']);
}

$renderer->assign('complete_torrents',$TORRENTS['complete']);
$renderer->assign('incomplete_torrents',$TORRENTS['incomplete']);

// Used in the iPhone UI to make the template DRYer.
$renderer->assign('torrents',array_merge($TORRENTS['complete'],$TORRENTS['incomplete']));
$renderer->display('torrents/list.tpl');

?>
