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
        'percent_complete' => $torrent->getPercentComplete(),
        'eta' => $torrent->getEstimatedTimeLeft(),
        'ratio' => $torrent->getRatio(),
    );
} // end torrent reformatting loop

$renderer->assign('complete_torrents',$TORRENTS['complete']);
$renderer->assign('incomplete_torrents',$TORRENTS['incomplete']);
$renderer->display('torrents/list.tpl');

?>
