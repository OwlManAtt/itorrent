--
-- PostgreSQL database dump
--

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- Name: jump_page_jump_page_id_seq; Type: SEQUENCE SET; Schema: public; Owner: itorrent
--

SELECT pg_catalog.setval('jump_page_jump_page_id_seq', 13, true);


--
-- Data for Name: jump_page; Type: TABLE DATA; Schema: public; Owner: itorrent
--

COPY jump_page (jump_page_id, page_title, page_html_title, page_slug, access_level, restricted_permission_api_name, php_script, active) FROM stdin;
1	Torrents	Torrents	torrents	user		torrents/list.php	Y
2	Authenticate	Authenticate	login	public		user/login.php	Y
3	Reset Password	Reset Password	reset-password	public		user/forgot_password.php	Y
4	Logout	Logout	logoff	public		user/logout.php	Y
5	Create User	Create User	create-user	restricted	manage-users	user/create.php	Y
6	Start/Stop Torrent	Start/Stop Torrent	toggle-status	restricted	manage-torrents	torrents/toggle_status.php	Y
7	Remove Torrent	Remove Torrent	remove-torrent	restricted	manage-torrents	torrents/remove.php	Y
8	Stop All Torrents	Stop All Torrents	stop-all-torrents	restricted	manage-torrents	torrents/stop_all.php	Y
9	rTorrent Settings	rTorrent Settings	client-settings	restricted	set-rate-limits	settings/configure.php	Y
10	Add Torrent	Add Torrent	add-torrent	restricted	manage-torrents	torrents/add.php	Y
11	Torrent Feeds	Torrent Feeds	rss-feeds	user		rss/list.php	Y
12	iTorrent	iTorrent	iphone-nav	user		meta/iphone_nav.php	Y
13	Torrent Details	Torrent Details	torrent-details	user		torrents/details.php	Y
\.


--
-- PostgreSQL database dump complete
--

