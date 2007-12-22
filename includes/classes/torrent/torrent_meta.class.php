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

    public function cacheTorrent($url)
    {
        $result = $this->findOneByUrl($url);
        if (!$result) {
            $TorrentProcessor = new Bittorrent2_Decode;
            $result = $TorrentProcessor->decodeFile($url); // TODO: Error Handling?

            $insert = array(	// TODO: Lrn2Getter
                'url'      => $url,
                'info_hash'=> $result['info_hash'],
                'name'=>      $result['name'],
                'size'=>      (int)$result['size']);

            $this->create($insert);
            $result = $this->findOneByUrl($url);
        }
        if (!$result) return "Error retrieving hash.";
        return $result->getInfoHash();
    } // end cacheTorrent
#    public function vacuumStaleEntries()
#    {
#        $stale = $this->
#        $stale->destroy()
#    }
} // end RSS

?>
