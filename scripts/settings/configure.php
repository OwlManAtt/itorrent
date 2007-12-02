<?php
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
        redirect('client-settings');
        
        break;
    } // end save
} // end switch
?>
