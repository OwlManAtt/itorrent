<?php
/**
 * Jumppage class definition.
 *
 * Jump pages translate slugs => files and provide important details
 * about the individual page, like permissions and layout.
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
 * JumpPage 
 * 
 * @uses ActiveTable
 * @package iTorrent
 * @subpackage Core 
 * @copyright 2007 Nicholas Evans
 * @author Nick 'Owl' Evans <owlmanatt@gmail> 
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 **/
class JumpPage extends ActiveTable
{
	protected $table_name = 'jump_page';
    protected $primary_key = 'jump_page_id';

	/**
	 * Determine if if $position has rights to view this page.
	 *
	 * @param User|null
	 * @return boolean
	 **/
	public function hasAccess($user)
	{
        if($user == null)
        {
            if($this->getAccessLevel() == 'public')
            {
                return true;
            }

            return false;
        } // end not logged in
        
        if($user->getAccessLevel() == 'banned')
        {
            return false;
        }

        if($this->getAccessLevel() == 'restricted')
        {
            return $user->hasPermission($this->getRestrictedPermissionApiName());
        }

        return true;
	} // end hasAccess
} // end JumpPage

?>
