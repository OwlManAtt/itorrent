<?php

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
    redirect('torrents');
} // end change status

?>
