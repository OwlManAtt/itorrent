<?php

$torrents = Torrent::findByStatus($APP_CONFIG['rpc_uri'],'all');

foreach($torrents as $torrent)
{
    if($torrent->getActive() == true)
    {
        $torrent->pause($APP_CONFIG['rpc_uri']);
    }
} // end torrent loop

$_SESSION['torrents_alert'] = "All torrents have been stopped.";
redirect('torrents');

?>
