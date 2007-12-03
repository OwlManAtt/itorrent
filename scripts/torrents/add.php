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
            redirect('torrents');
        } // end no errors

        break;
    } // end add
    
} // end switch
?>
