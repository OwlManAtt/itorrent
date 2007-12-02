<?php

$hash_id = stripinput($_POST['hash_id']);
$torrent = Torrent::findOneByHash($APP_CONFIG['rpc_uri'],$hash_id);

if($torrent == null)
{
    draw_errors('Invalid torrent hash specified.');
}
else
{
    $name = $torrent->getTitle();
    $torrent->remove($APP_CONFIG['rpc_uri']);

    $_SESSION['torrents_alert'] = "$name was removed.";
    redirect('torrents');
} // end change status

?>
