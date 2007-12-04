<?php

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
