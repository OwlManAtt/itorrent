<?php
/**
 * Config files; includes all critical libraries & sets paths.
 *
 * This file is part of 'Kitto_Kitto_Kitto'.
 *
 * 'Kitto_Kitto_Kitto' is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 3 of the License,
 * or (at your option) any later version.
 * 
 * 'Kitto_Kitto_Kitto' is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE.  See the GNU General Public
 * License for more details.
 * 
 * You should have received a copy of the GNU General
 * Public License along with 'Kitto_Kitto_Kitto'; if not,
 * write to the Free Software Foundation, Inc., 51
 * Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @author Nicholas 'Owl' Evans <owlmanatt@gmail.com>
 * @copyright Nicolas Evans, 2007
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @package Kitto_Kitto_Kitto
 * @subpackage Core
 * @version 1.0.0
 **/

/**
 * Include the exception handlers before our switch.
 * 
 * This keeps the config DRY, since it's setting based on
 * the RELEASE_MODE and the function has to be defined
 * _before_ the set_exception_handler() call.
 **/
require('includes/meta/debug.php');

// Comment this out to try and pull in the RELEASE_MODE from the
// .htaccess file. It may not work, depending on Apache's setup.
$_SERVER['RELEASE_MODE'] = 'DEV';

switch($_SERVER['RELEASE_MODE'])
{
	case 'DEV':
	{
        // Even if your host has error reporting turned off, this *should* 
        // force PHP to send errors to the browser. This is immensely useful
        // during setup / development, but it's probably not wanted in a 
        // production environment.
        error_reporting(E_ALL ^ E_NOTICE);

        // Make the errors useful for dev.
        set_exception_handler('development_exception_handler');
        
		$APP_CONFIG = array(
            /**
             * The datasource name for your database.
             * 
             * phptype  = PEAR::DB driver to use (mysql, oci)
             * username = The database user to connect as.
             * password = The password for your database user. 
             * database = The database to USE.
             * hostspec = The hostname to connect to. If you don't know what
             *            this is, the default 'localhost' is probably correct.
             *
             * @var array
             **/
			'db_dsn' => array(
				'phptype' => 'mysql', // This can also be run on Oracle (oci).
				'username' => 'itorrent',
				'password' => '1torr3nty0U',
				'hostspec' => 'localhost',
				'database' => 'itorrent',
			),
            
            /**
             * The administator's e-mail address. Password recovery notices
             * come from this address, too!
             **/
            'administrator_email' => 'owlmanatt@gmail.com',
            
            /**
             * The absolute path (on the filesystem) to your app. On UNIX,
             * this should look like /something/something/something.
             *
             * If you don't know what this should be, put a file calling
             * phpinfo() into the folder you want KKK to live in and visit
             * it in your browser. Look for the 'SCRIPT_FILENAME' field.
             * The base path is everything *except* for the filename.
             **/
			'base_path' => '/var/www/itorrent',
            
            /**
             * The path to the root of your Smarty template directory.
             * The templates/, templates_c/, cache/, and configs/ folders
             * live in here.
             **/
			'template_path' => '/var/www/itorrent/template',

            /*
             * The full URL (no trailing slash) to your site.
             * ie, 'http://demo.kittokittokitto.yasashiisyndicate.org'
             **/
			'public_dir' => 'http://bell.owl.ys/itorrent',
            
            /**
             * If you have many sites at this domain, a cookie prefix
             * is good to ensure there's no overlap between your various
             * apps' cookies.
             **/
			'cookie_prefix' => 'it_',

            /**
             * The name of your site.
             **/
            'site_name' => 'iTorrent - Bubo',

            /**
             * The URI for your RPC service.
             **/
            'rpc_uri' => 'http://bubo.owl.ys/RPC2',
            // 'rpc_uri' => 'http://ragudo.ib.ys/RPC2',
		);
		
		break;
	} // end dev
	
	default:
	{
		die("RELEASE_MODE '{$_SERVER['RELEASE_MODE']}' unrecognized; CANNOT PROCEED.");
		
		break;
	} // end default

} // end release mode switch

// PEAR::DB gets very angry when it cannot include files in external_libs/DB/.
ini_set('include_path',ini_get('include_path').':./external_lib/');

/**
 * These are mission-critical libraries. Nothing else will function 
 * correctly without these. APHP needs to come before any other classes,
 * otherwise they will cause a fatal error because their parent class is
 * undefined.
 **/
require_once('external_lib/DB.php');
require_once('external_lib/Log.php');
require_once('external_lib/aphp/aphp.php');
require_once('XML/RPC2/Client.php');

/**
 * KKK library files.
 **/
require('includes/meta/macros.lib.php');
require('includes/meta/jump_page.class.php');
require('includes/meta/pagination.php');
require('includes/classes/classes.config.php');

$DB_OPTIONS = array(
	'debug' => 2,
	'portability' => DB_PORTABILITY_ALL,
);

$db = DB::connect($APP_CONFIG['db_dsn'],$DB_OPTIONS);
if (PEAR::isError($db)) 
{
    die("An error occured when attempting to connect to the database. Oops!");
}
$db->setFetchMode(DB_FETCHMODE_ASSOC);

?>
