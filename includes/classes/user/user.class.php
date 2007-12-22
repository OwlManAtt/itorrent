<?php
/**
 * User classfile. 
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
 * User class.
 *
 * This provides all user-related attributes and has RELATED sets defined
 * for most things a user owns. 
 * 
 * @uses ActiveTable
 * @package iTorrent
 * @subpackage Core 
 * @copyright 2007 Nicholas Evans
 * @author Nick 'Owl' Evans <owlmanatt@gmail> 
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 **/
class User extends ActiveTable
{
    protected $table_name = 'user';
    protected $primary_key = 'user_id';
    protected $RELATED = array(
        'staff_groups' => array(
            'class' => 'User_StaffGroup',
            'local_key' => 'user_id',
            'foreign_key' => 'user_id',
        ),
    );

    /**
     * Caches loaded permissions so another SQL lookup doesn't need to be done. 
     * 
     * @var array
     **/
    protected $permission_cache = array();

    /**
	 * Set the password for a user by passing in plaintext.
	 *
	 * The plaintext password is automagically converted to the
	 * appropriate format and stored. The plaintext is discarded
	 * when this function completes.
     *
     * The password hash is built using a random salt + the plaintext.
     * The salt is the md5 of random data + the current time + a string 
     * that (hopefully) has *at least* one symbol that wasn't factored 
     * into a rainbow table.
     * 
     * @param string $password 
     * @return void
     **/
	public function setPassword($password)
	{
     	$salt = md5(rand(10000000,90000000).time().'isumi*+!@#|=');
        $this->setPasswordHashSalt($salt);

        $this->setPasswordHash(md5(md5($password.$salt)));
	} // end setPassword
    
    /**
     * Determine if plaintext matches the hashed password. 
     * 
     * @param string $plaintext 
     * @return bool 
     **/
    public function checkPlaintextPassword($plaintext)
    {
        $base = md5(md5($plaintext.$this->getPasswordHashSalt()));
        
        if($base == $this->getPasswordHash())
        {
            return true;
        }

        return false;
    } // end checkPassword
	
    /**
     * Determines if the salted hash sent to the client is correct. 
     * 
     * @param string $session_password 
     * @return bool 
     **/
    public function checkSessionPassword($session_password)
    {
        $base = $this->getPasswordHash();
        $salt = $this->getCurrentSalt();
        
        // If the salt is expired, tear the user down.
        if(strtotime($this->getCurrentSaltExpiration()) < time())
        {
            $this->logout();

            return false;
        } // end logout if salt expired
        
        if(md5($base.$salt) == $session_password)
        {
            return true;
        }
        
        return false;
    } // end checkSessionPassword
    
	/**
	 * Log in as this user.
	 *
	 * @param integer The duration the cookie should exist for.
	 * @return void
	 **/
	public function login($cookie_duration=2592000)
	{
		global $APP_CONFIG;

		if($cookie_duration > 0)
		{
			$username = $this->getUserName();
			$password = $this->getPasswordHash();
			$time = time() + $cookie_duration;
        
            // Generate and store the salt we're using for this session.
            $salt = md5((rand(1,100000) * rand(1,1000)));
            $this->setCurrentSalt($salt);
            $this->setCurrentSaltExpiration(date('Y-m-d H:i:s',$time));
            $this->save();

            // Better password hash.
            $password = md5($password.$salt);
		} // end logging in
		else
		{
			$username = null;
			$password = null;
			$time = $_COOKIE[$APP_CONFIG['cookie_prefix'].'time'];
            
            // Rip the salt down.
            $this->setCurrentSalt('');
            $this->setCurrentSaltExpiration(0);
            $this->save();
		} // end zeroing
		
		setcookie("{$APP_CONFIG['cookie_prefix']}username",$username,$time,'/');
		setcookie("{$APP_CONFIG['cookie_prefix']}hash",$password,$time,'/');
		setcookie("{$APP_CONFIG['cookie_prefix']}time",$time,$time,'/');
		
		return null;
	} // end login
	
	/**
	 * Tear down a users' session.
	 *
	 * @return void
	 **/
	public function logout()
	{
		$this->login(-1);
	} // end logout
	
    /**
     * Format and localize a timestamp for displaying to this user.
     * 
     * @param string|int $datetime A UNIX timestamp. A non-int will be
     *                      converted with strototime().
     * @return string The localized date/time.
     **/
	public function formatDate($datetime)
	{
        if(is_string($datetime)) $datetime = strtotime($datetime);
        $gmt_unix = gmdate('U',$datetime); 

        $offset = ($this->getTimezoneOffset() * (60 * 60));
        $local_unix = $gmt_unix + $offset;

        return date($this->getDatetimeFormat(),$gmt_unix);
	} // end formatdate

    /**
     * Determine if this user has a permission. 
     *
     * This works by checking a the object's cache for a permission. If it
     * is cached, a lookup is done to grab it from the DB (slow, many joins).
     * The permission is added to the cache and the cached value is returned.
     * 
     * @param string $permission The permission's name.
     * @return bool
     **/
	public function hasPermission($permission)
	{
        // Fucktarded developer protection.
        $permission = strtolower($permission);
        
        if(array_key_exists($permission,$this->permission_cache) == false)
        {
            $result = $this->db->getOne('
                SELECT 
                    count(*) AS has_permission
                FROM user
                INNER JOIN user_staff_group ON user.user_id = user_staff_group.user_id
                INNER JOIN staff_group_staff_permission ON user_staff_group.staff_group_id = staff_group_staff_permission.staff_group_id
                INNER JOIN staff_permission ON staff_group_staff_permission.staff_permission_id = staff_permission.staff_permission_id
                WHERE staff_permission.api_name = ?
                AND user.user_id = ?
            ',array($permission,$this->getUserId()));

            if(PEAR::isError($result))
            {
                throw new SQLError($result->getDebugInfo(),$result->userinfo,10);
            }

            $this->permission_cache[$permission] = (bool)$result;
        } // end do load
        
        return $this->permission_cache[$permission];
	} // end hasPermission

    /**
     * Grab the list of groups.
     *
     * This method is kinda slow. To retain its agnosticism, I didn't
     * write a query to go directly from user => group. The actual RELATED
     * entry grabs rows from user_staff_group and then loads the group for
     * each of those rows.
     * 
     * @return array An array of UserGroups. 
     **/
    public function grabStaffGroups()
    {
        $groups = $this->grab('staff_groups');

        $REAL = array();
        foreach($groups as $group)
        {
            $REAL[] = $group->grabGroup();
        } // end grouploop

        return $REAL;
    } // end grabGroups

    public function updateGroups($group_ids)
    {
        // Delete all is a little different.
        if(sizeof($group_ids) == 0)
        {
            $result = $this->db->query('DELETE FROM user_staff_group WHERE user_id = ?',array($this->getUserId()));
                  
            if(PEAR::isError($result))
            {
                throw new SQLError($result->getDebugInfo(),$result->userinfo,10);
            }

            return true;
        } // end handle delete all
        
        // Handle the delete or add *some*.
        $holders = array_fill(0,(sizeof($group_ids)),'?');
        $holders = implode(',',$holders);
        
        $result = $this->db->query("
            DELETE FROM user_staff_group 
            WHERE staff_group_id NOT IN ($holders) 
            AND user_id = ?
        ",array_merge($group_ids,array($this->getUserId())));
        
        if(PEAR::isError($result))
        {
            throw new SQLError($result->getDebugInfo(),$result->userinfo,10);
        }
        
        $result = $this->db->query("
            INSERT IGNORE INTO user_staff_group 
            (staff_group_id,user_id) 
            SELECT 
                staff_group_id, 
                ? AS user_id 
            FROM staff_group
            WHERE staff_group_id IN ($holders)
        ",array_merge(array($this->getUserId()),$group_ids));

        if(PEAR::isError($result))
        {
            throw new SQLError($result->getDebugInfo(),$result->userinfo,10);
        }
        
        return true;
    } // end updateGroups
} // end User 

?>
