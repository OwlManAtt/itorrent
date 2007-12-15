<?php
/**
 * Client settings for rTorrent. 
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

class Settings extends rTorrent 
{
    protected $rpc = '';

    protected $torrent_max_peer_slot;
    protected $torrent_max_upload_slot;
    protected $torrent_max_seed_slot;

    protected $max_upload_slot;
    protected $max_download_slot;
    protected $max_upload_rate;
    protected $max_download_rate;
    
    private $SETTINGS = array(
        // Array format: attribute name, RPC getter, RPC setter
        // Per-torrent settings
        array('torrent_max_peer_slot', 'get_max_peers', 'set_max_peers'),
        array('torrent_max_upload_slot', 'get_max_uploads', 'set_max_uploads'),
        array('torrent_max_seed_slot', 'get_max_peers_seed', 'set_max_peers_seed'),

        // Global settings.
        array('max_upload_slot', 'get_max_uploads_global', 'set_max_uploads_global'),
        array('max_download_slot', 'get_max_downloads_global', 'set_max_downloads_global'),
        array('max_download_rate', 'get_download_rate', 'set_download_rate'),
        array('max_upload_rate', 'get_upload_rate', 'set_upload_rate'),
    );

    public function __construct($rpc_url)
    {
        $this->rpc = XML_RPC2_Client::create($rpc_url,array('prefix' => 'system.'));
        $this->_load();
    } // end __construct

    public function save()
    {
        $args = array();
        foreach($this->SETTINGS as $method)
        {
            $key = $method[0];

            $args[] = array(
                'methodName' => $method[2], 
                'params' => array($this->$key),
            );
        } // end generate multicall params

        $results = $this->rpc->multicall($args);

        // Reload to get the 'real' settings.
        $this->_load();
    } // end save

    public function set($key,$value)
    {
        $this->$key = $value;
    } // end set
    
    private function _load()
    {
        $args = array();
        foreach($this->SETTINGS as $method)
        {
            $args[] = array(
                'methodName' => $method[1], 
                'params' => array('')
            );
        } // end generate multicall params

        $results = $this->rpc->multicall($args);
        
        foreach($results as $i => $r)
        {
            $key = $this->SETTINGS[$i][0];
            $this->$key = $r[0];
        } // end put into $this loop
    } // end _load
} // end ClientSettings

?>
