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
-- Name: staff_permission_staff_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: itorrent
--

SELECT pg_catalog.setval('staff_permission_staff_permission_id_seq', 3, true);


--
-- Data for Name: staff_permission; Type: TABLE DATA; Schema: public; Owner: itorrent
--

COPY staff_permission (staff_permission_id, api_name, permission_name) FROM stdin;
1	manage-torrents	Manage Torrents
2	set-rate-limits	Modify Rate Limits
3	manage-users	Add/Delete Users
\.


--
-- PostgreSQL database dump complete
--

