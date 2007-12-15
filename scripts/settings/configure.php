<?php
/**
 * Client config page. 
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


$settings = new Settings($APP_CONFIG['rpc_uri']);

switch($_REQUEST['state'])
{
    default:
    {
        $SETTINGS = array(
            'per_torrent' => array(
                'max_peer_slot' => $settings->getTorrentMaxPeerSlot(),
                'max_upload_slot' => $settings->getTorrentMaxUploadSlot(),
                'max_seed_slot' => $settings->getTorrentMaxSeedSlot(),
            ),
            'global' => array(
                'max_upload_slot' => $settings->getMaxUploadSlot(),
                'max_download_slot' => $settings->getMaxDownloadSlot(),
                'max_upload_rate' => $settings->getMaxUploadRate() / 1024,
                'max_download_rate' => $settings->getMaxDownloadRate() / 1024,
            ),
        );

        if(isset($_SESSION['settings_alert']) == true)
        {
            $renderer->assign('alert',$_SESSION['settings_alert']);
            unset($_SESSION['settings_alert']);
        }

        $renderer->assign('per_torrent',$SETTINGS['per_torrent']);
        $renderer->assign('global',$SETTINGS['global']);
        $renderer->display('settings/configure.tpl');

        break;
    } // end default
    
    case 'save':
    {
        $SETTINGS = array(
            'torrent_max_peer_slot' => stripinput($_POST['settings']['per_torrent']['max_peer_slot']),
            'torrent_max_seed_slot' => stripinput($_POST['settings']['per_torrent']['max_seed_slot']),
            'torrent_max_upload_slot' => stripinput($_POST['settings']['per_torrent']['max_upload_slot']),
             
            'max_upload_slot' => stripinput($_POST['settings']['global']['max_upload_slot']),
            'max_download_slot' => stripinput($_POST['settings']['global']['max_download_slot']),
            'max_upload_rate' => stripinput($_POST['settings']['global']['max_upload_rate']) * 1024,
            'max_download_rate' => stripinput($_POST['settings']['global']['max_download_rate']) * 1024,
        );
        
        // Save!
        foreach($SETTINGS as $var => $value)
        {
            $value = (int)$value;
            if($value < 0)
            {
                $value = 0;
            }
             
            $settings->set($var,$value);
        }
        $settings->save();

        $_SESSION['settings_alert'] = 'The settings have been saved.'; 

        if($UI_TYPE == 'iphone')
        {
            // -home is the no-layout version of -nav
            redirect('iphone-home');
        }
        else
        {
            redirect('client-settings');
        }
        
        break;
    } // end save
} // end switch
?>
