<?php
/**
 * ActiveXMLRPC class representing torrents. 
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


class Torrent extends rTorrent 
{
    protected $hash;
    protected $title;
    protected $bytes_complete;
    protected $bytes_incomplete;
    protected $active;
    protected $complete;
    protected $leecher_count_connected;
    protected $leecher_count_unconnected;
    protected $seed_count;
    protected $upload_speed;
    protected $download_speed;
    protected $ratio;
   
    static public function getQueryAttributes()
    {
        return array(
            array('hash', 'd.get_hash='),
            array('title', 'd.get_name='),
            array('bytes_complete', 'd.get_completed_bytes='),
            array('bytes_incomplete', 'd.get_left_bytes='),
            array('active', 'd.is_active='),
            array('complete', 'd.get_complete='),
            array('leecher_count_connected', 'd.get_peers_connected='),
            array('leecher_count_unconnected', 'd.get_peers_not_connected='),
            array('seed_count', 'd.get_peers_complete='),
            array('upload_speed', 'd.get_up_rate='),
            array('download_speed', 'd.get_down_rate='),
            array('ratio', 'd.get_ratio='),
        );
    } // end getQueryAttributes

    static public function buildMulticallString($query)
    {
        $args = array();
        foreach($query as $arg)
        {
            $args[] = "'{$arg[1]}'";
        }
        $args = implode(',',$args);
       
        return $args; 
    } // end buildMulticallString
    
    static public function findByStatus($rpc_url,$status='all')
    {
        // Make the API call friendly.
        if($status == 'all')
        {
            $status = 'main';
        }

        $query =  Torrent::getQueryAttributes();
        $args = Torrent::buildMulticallString($query);
        $client = XML_RPC2_Client::create($rpc_url,array('prefix' => 'd.','encoding' => 'utf-8')); 
        
        eval('$torrents_raw = $client->multicall($status,'.$args.');');
        
        $TORRENTS = array();
        foreach($torrents_raw as $t)
        {
            $data = array();
            foreach($t as $i => $value)
            {
                $data[$query[$i][0]] = $value;
            }

            $torrent = new Torrent($data);
            $TORRENTS[] = $torrent;
        } // end torrents raw loop
    
        return $TORRENTS;
    } // end fineByStatus

    /**
     * Find a torrent by its hash. 
     * 
     * @param mixed $rpc_url 
     * @param mixed $hash 
     * @return Torrent|null
     * @todo Inefficient. Re-implement to not suck.
     **/
    static public function findOneByHash($rpc_url,$hash)
    {
        $torrents = Torrent::findByStatus($rpc_url,'all');

        foreach($torrents as $torrent)
        {
            if($torrent->getHash() == $hash)
            {
                return $torrent;
            }
        } // end loop

        return null;
    } // end findOneByHash

    static public function create($rpc_url,$torrent_uri,$start=true)
    {
        $client = XML_RPC2_Client::create($rpc_url,array());

        if($start == true)
        {
            $client->load_start_verbose($torrent_uri);
        }
        else
        {
            $client->load_verbose($torrent_uri);
        }

        return true;
    } // end create
    
    public function __construct($attributes)
    {
        foreach($attributes as $key => $value)
        {
            $this->$key = $value;
        }
    } // end constructor

    public function getPercentComplete()
    {
        if($this->getBytesComplete() == 0)
        {
            return 0;
        }
        
        return round(($this->getBytesComplete() / ($this->getBytesComplete() + $this->getBytesIncomplete()) * 100),1);
    } // end getPercentComplete

    public function getLeecherCount()
    {
        return ($this->getLeecherConnected() + $this->getLeecherUnconnected());
    } // end getLeecherCount

    public function getTotalBytes()
    {
        return (float)((float)$this->getBytesComplete() + (float)$this->getBytesIncomplete());
    } // end getTotalBytes
    
    public function getFormattedBytesComplete()
    {
        return $this->filesize_format($this->getBytesComplete());
    } // end getFormattedBytesComplete

    public function getFormattedBytesIncomplete()
    {
        return $this->filesize_format($this->getBytesIncomplete());
    } // end getFormattedBytesIncomplete
    
    public function getFormattedTotalBytes()
    {
        return $this->filesize_format($this->getTotalBytes());
    } // end getFormattedTotalBytes

    public function getFormattedUploadSpeed()
    {
        return $this->filesize_format($this->getUploadSpeed());
    } // end getFormattedUploadSpeed

    public function getFormattedDownloadSpeed()
    {
        return $this->filesize_format($this->getDownloadSpeed());
    } // end getFormattedDownloadSpeed

    public function getEstimatedSecondsLeft()
    {
        if($this->getDownloadSpeed() == 0)
        {
            return null;
        }

        return round($this->getBytesIncomplete() / (float)$this->getDownloadSpeed());
    } // end getEstimatedSecondsLeft

    public function getEstimatedTimeLeft()
    {
        if($this->getActive() == false)
        {
            return 'Paused';
        }

        $seconds = $this->getEstimatedSecondsLeft();
        if($seconds === null)
        {
            // HTML ent for infinity
            return '&#8734';
        }
        
        return $this->duration($seconds);
    } // end getEstimatedTimeLeft

    public function getRatio()
    {
        return round(($this->ratio / 1000),2);
    } // end getRadio

   /**
     * Format a number of bytes into a human readable format.
     * Optionally choose the output format and/or force a particular unit
     *
     * @link http://www.phpriot.com/d/code/strings/filesize-format/index.html
     * @param   int     $bytes      The number of bytes to format. Must be positive
     * @param   string  $force      Optional. Force a certain unit. B|KB|MB|GB|TB
     * @return  string              The formatted file size
     */
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
    
    /* ===========    Actoions    =========== */
    public function pause($rpc_url)
    {
        $client = XML_RPC2_Client::create($rpc_url,array('prefix' => 'd.'));
        $return = $client->stop($this->getHash());
        
        return true;
    } // end pause

    public function start($rpc_url)
    {
        $client = XML_RPC2_Client::create($rpc_url,array('prefix' => 'd.'));
        $return = $client->start($this->getHash());
    
        return true;
    } // end start

    public function remove($rpc_url)
    {
        $client = XML_RPC2_Client::create($rpc_url,array('prefix' => 'd.'));
        $return = $client->erase($this->getHash());

        unset($this);
    } // end remove

} // end Torrent
?>
