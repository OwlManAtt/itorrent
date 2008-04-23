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
-- Name: staff_group_staff_permission_staff_group_staff_permission_seq; Type: SEQUENCE SET; Schema: public; Owner: itorrent
--

SELECT pg_catalog.setval('staff_group_staff_permission_staff_group_staff_permission_seq', 4, true);


--
-- Data for Name: staff_group_staff_permission; Type: TABLE DATA; Schema: public; Owner: itorrent
--

COPY staff_group_staff_permission (staff_group_staff_permission, staff_group_id, staff_permission_id) FROM stdin;
1	1	1
2	2	2
4	3	2
3	3	3
\.


--
-- PostgreSQL database dump complete
--

