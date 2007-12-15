<?php
/**
 * Staff groups <=> users map. 
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
 * @subpackage Core
 * @version 1.0.0
 **/

/**
 * Staff groups <=> users map. 
 * 
 * @uses ActiveTable
 * @package iTorrent
 * @subpackage Core 
 * @copyright 2007 Nicholas Evans
 * @author Nick 'Owl' Evans <owlmanatt@gmail> 
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPL v3
 **/
class User_StaffGroup extends ActiveTable
{
    protected $table_name = 'user_staff_group';
    protected $primary_key = 'user_staff_group_id';
    protected $RELATED = array(
        'group' => array(
            'class' => 'StaffGroup',
            'local_key' => 'staff_group_id',
            'foreign_key' => 'staff_group_id',
            'one' => true,
        ),
    );

} // end User_StaffGroup

?>
