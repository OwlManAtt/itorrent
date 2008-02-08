<?php
/**
 * Config file that includes all other classes. This is to keep main clean. 
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
 * Abstract classes come first, lest their children cause fatal errors.
 **/
require('getter.class.php');

/**
 * Exception library.
 **/
 require('exceptions.class.php');

/**
 * User-related classes.
 **/
require('user/user.class.php');
require('user/user_staff_group.class.php');
require('user/staff_group.class.php');
require('user/staff_permission.class.php');

/**
 * rTorrent XML-APC API wrappers.
 **/
require('rtorrent/rtorrent.class.php');
require('rtorrent/torrent.class.php');
require('rtorrent/settings.class.php');

/**
 * RSS feed parsin' goodness
 **/
require('rss/rss_feed.class.php');
require('rss/rss_feed_item.class.php');
require('rss/rss_highlight.class.php');

/**
 * Additional data sources to make the UI nicer
 **/
require('torrent/torrent_meta.class.php');
?>
