<?php
/**
 * Obtain additional data on the torrents via torrent URL.
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
 * @author Stacey 'InfinityB' Ell <stacey.ell@gmail.com>
 * @copyright Stacey Ell, 2007
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @package iTorrent
 * @version 1.0.0
 **/


class TorrentMeta extends ActiveTable
{
    protected $table_name = 'torrent_meta';
    protected $primary_key = 'torrent_meta_id';

    public function getFormattedSize()
    {
        return $this->filesize_format($this->getSize());
    } // end getFormattedSize

    protected function filesize_format($bytes,$force = '')
    {
        $force = strtoupper($force);
    
        $bytes = max(0, $bytes);
    
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    
        $power = array_search($force, $units);
    
        if ($power === false)
            $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
    
        $size = number_format(($bytes / pow(1024,$power)),2);
        $size = explode('.',$size);
    
        if($size[1] == '00')
        {
            // Drop the '.00', it's useless.
            $size = $size[0];
        }
        else
        {
            $size = implode('.',$size);
        }
        return $size.' '.$units[$power];
    } // end filesize_format

    private function torrent_data_extractor($str)
    {
        $TorrentProcessor = new Bencode();

        try 
        { 
            $result = $TorrentProcessor->decode($str); 
        }
        catch(Exception $e) 
        { 
            throw new TorrentInvalidError($e->getMessage());
        }

        $size = 0;
        if($result['info']['length'])
        {
            $size = $result['info']['length'];
        }
        else
        {
            foreach($result['info']['files'] as $file)
            {
                $size += $file['length'];
            }
        } // end sum files

        $infohash = sha1($TorrentProcessor->encode($result['info']));
        
        $filecount = 1;
        if($result['info']['files']) 
        {
            $filecount = count($result['info']['files']);
        }

        return array(
            'name' => $result['info']['name'],
            'size' => $size,
            'infohash' => $infohash,
            'files' => $filecount,
        );
    } // end torrent_data_extractor

    /**
     * Add the torrent to the cache, if it is not already there. 
     * 
     * @param string $url The URL of the .torrent .
     * @param integer $parent_feed_id The RSS feed to associate this with. This is ONLY used
     *                                for cleanup purposes. If two RSS feeds list the same 
     *                                torrent URI, it will only be downloaded and cached once.
     * @return bool 
     **/
    public function cacheTorrent($url,$parent_feed_id)
    {
        $torrent = $this->findOneByUrl($url);
        if($torrent == null) 
        {
            $torrent_raw = @file_get_contents($url);
            if($torrent_raw === false)
            {
                throw new TorrentUnavailableError('The torrent could not be downloaded.');
            }

            $METADATA = $this->torrent_data_extractor($torrent_raw);
            $METADATA['rss_feed_id'] = $parent_feed_id;
            $METADATA['url'] = $url;
            $METADATA['cached_datetime'] = $this->sysdate();
            
            $this->create($METADATA);
        } // end torrent not found in cache

        return true;
    } // end cacheTorrent
} // end RSS

?>
