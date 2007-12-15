<?php
/**
 * Sign-up for new users. 
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

switch($_REQUEST['state'])
{
	default:
	{
		$renderer->display('user/create_form.tpl');
		
		break;
	} // end default
	
	case 'process':
	{
		$ERRORS = array();
		
		$USER = array(
			'user_name' => stripinput($_POST['user']['user_name']),
			'password' => $_POST['user']['password'], // Don't care about shit in here - the md5sum is what hits the db.
			'email' => $_POST['user']['email'],
		);
		
		if($USER['user_name'] == null)
		{
			$ERRORS[] = 'You cannot create an account with a blank username.';
		}
		elseif(preg_match('/^[A-Z0-9_!@#\$%\^&\*\(\)\.-]*$/i',$USER['user_name']) == false)
		{
			$ERRORS[] = 'Invalid characters in your username. Try A-Z0-9_!@#$%^&*().,;:.';
		}
		elseif(strlen($USER['user_name']) > 25)
		{
			$ERRORS[] = 'There is a maxlength=25 attribute on that input tag for a reason.';
		}
		else
		{
			$user_check = new User($db);
			$user_check = $user_check->findOneByUserName($USER['user_name']);
			
			if(is_a($user_check,'User') == true)
			{
				$ERRORS[] = 'That user name is already taken.';
			}
			
		} // end username is valid
		
		if($USER['password'] == null)
		{
			$ERRORS[] = 'Specified password was blank.';
		}
		elseif($USER['password'] != $_POST['user']['password_again'])
		{
			$ERRORS[] = 'Your password did not match the confirmation field.';
		}

        if($USER['email'] == null)
        {
            $ERRORS[] = 'E-mail address was blank.';
        }
        elseif(preg_match('/^[a-z0-9_+.]{1,64}@([a-z0-9-.]*){1,}\.[a-z]{1,5}$/i',$USER['email']) == false) // Doesn't adhere to RFC.
        {
            $ERRORS[] = 'Invalid e-mail address specified.';
        }
        
		if(sizeof($ERRORS) > 0)
		{
			draw_errors($ERRORS);
		}
		else
		{			
			// Create an user and set some base attrs.
			$new_user = new User($db);
			$new_user->setUserName($USER['user_name']);
			$new_user->setPassword($USER['password']);
            $new_user->setEmail($USER['email']);
            $new_user->setDatetimeCreated($new_user->sysdate());
			$new_user->save();
			
			// Log the user in and send him back home.
			$new_user->login();
			redirect('torrents');
		} // end success
			
		break;
	} // end process
} // end switch

?>
