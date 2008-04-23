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
-- Name: staff_group_staff_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: itorrent
--

SELECT pg_catalog.setval('staff_group_staff_group_id_seq', 3, true);


--
-- Data for Name: staff_group; Type: TABLE DATA; Schema: public; Owner: itorrent
--

COPY staff_group (staff_group_id, group_name, group_descr, order_by) FROM stdin;
1	Torrenters	Individuals in this group may add, start, stop, and delete torrents.	0
2	Torrent Administrators	Individuals in this group have control over rate limiting rTorrent.	0
3	User Admin	Create and delete iTorrent users.	0
\.


--
-- PostgreSQL database dump complete
--

