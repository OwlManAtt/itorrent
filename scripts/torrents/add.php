<?php

switch($_REQUEST['state'])
{
    default:
    {
        $renderer->display('torrents/add.tpl');

        break;
    } // end default

    case 'add':
    {
        $start_immediately = true;
        if($_POST['torrent']['pause'] == 'false')
        {
            $start_immediately = false;
        }
        
        $torrent = Torrent::create($APP_CONFIG['rpc_uri'],$_POST['torrent']['uri'],$start_immediately);

        $_SESSION['torrents_alert'] = 'Torrent added. It should show up soon...maybe.';
        redirect('torrents');

        break;
    } // end add
    
} // end switch
?>
