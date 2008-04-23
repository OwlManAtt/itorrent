--
-- PostgreSQL database dump
--

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: jump_page; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE jump_page (
    jump_page_id integer NOT NULL,
    page_title character varying(50) DEFAULT ''::character varying NOT NULL,
    page_html_title character varying(255) DEFAULT ''::character varying NOT NULL,
    page_slug character varying(25) DEFAULT ''::character varying NOT NULL,
    access_level character varying(10) DEFAULT 'user'::character varying NOT NULL,
    restricted_permission_api_name character varying(35) NOT NULL,
    php_script character varying(100) DEFAULT ''::character varying NOT NULL,
    active character(1) DEFAULT 'Y'::bpchar NOT NULL,
    CONSTRAINT jump_page_access_level_check CHECK (((access_level)::text = ANY ((ARRAY['restricted'::character varying, 'user'::character varying, 'public'::character varying])::text[]))),
    CONSTRAINT jump_page_active_check CHECK ((active = ANY (ARRAY['Y'::bpchar, 'N'::bpchar])))
);


ALTER TABLE public.jump_page OWNER TO itorrent;

--
-- Name: rss_feed; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE rss_feed (
    rss_feed_id integer NOT NULL,
    feed_title character varying(20) NOT NULL,
    feed_url text NOT NULL,
    "default" character(1) DEFAULT 'N'::bpchar NOT NULL,
    fetch_metadata character(1) DEFAULT 'N'::bpchar NOT NULL,
    metadata_expire_seconds integer DEFAULT 0 NOT NULL,
    CONSTRAINT rss_feed_default_check CHECK (("default" = ANY (ARRAY['N'::bpchar, 'Y'::bpchar]))),
    CONSTRAINT rss_feed_fetch_metadata_check CHECK ((fetch_metadata = ANY (ARRAY['Y'::bpchar, 'N'::bpchar])))
);


ALTER TABLE public.rss_feed OWNER TO itorrent;

--
-- Name: rss_highlight; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE rss_highlight (
    rss_highlight_id integer NOT NULL,
    highlight_preg text NOT NULL,
    highlight_type character varying(10) NOT NULL,
    CONSTRAINT rss_highlight_highlight_type_check CHECK (((highlight_type)::text = ANY ((ARRAY['important'::character varying, 'minimize'::character varying])::text[])))
);


ALTER TABLE public.rss_highlight OWNER TO itorrent;

--
-- Name: staff_group; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE staff_group (
    staff_group_id integer NOT NULL,
    group_name character varying(50) NOT NULL,
    group_descr text NOT NULL,
    order_by integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.staff_group OWNER TO itorrent;

--
-- Name: staff_group_staff_permission; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE staff_group_staff_permission (
    staff_group_staff_permission integer NOT NULL,
    staff_group_id integer NOT NULL,
    staff_permission_id integer NOT NULL
);


ALTER TABLE public.staff_group_staff_permission OWNER TO itorrent;

--
-- Name: staff_permission; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE staff_permission (
    staff_permission_id integer NOT NULL,
    api_name character varying(50) NOT NULL,
    permission_name character varying(50) NOT NULL
);


ALTER TABLE public.staff_permission OWNER TO itorrent;

--
-- Name: torrent_meta; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE torrent_meta (
    torrent_meta_id integer NOT NULL,
    rss_feed_id integer NOT NULL,
    url text NOT NULL,
    infohash character(40) NOT NULL,
    name text NOT NULL,
    size bigint NOT NULL,
    files integer NOT NULL,
    cached_datetime timestamp without time zone NOT NULL
);


ALTER TABLE public.torrent_meta OWNER TO itorrent;

--
-- Name: user; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE "user" (
    user_id integer NOT NULL,
    user_name character varying(25) NOT NULL,
    password_hash character(32) DEFAULT NULL::bpchar,
    password_hash_salt character(32) NOT NULL,
    current_salt character(32) NOT NULL,
    current_salt_expiration timestamp without time zone NOT NULL,
    last_ip_addr character varying(16) DEFAULT NULL::character varying,
    last_activity timestamp without time zone,
    email text NOT NULL,
    datetime_created timestamp without time zone,
    password_reset_requested timestamp without time zone NOT NULL,
    password_reset_confirm character varying(32) NOT NULL
);


ALTER TABLE public."user" OWNER TO itorrent;

--
-- Name: user_staff_group; Type: TABLE; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE TABLE user_staff_group (
    user_staff_group_id integer NOT NULL,
    user_id integer NOT NULL,
    staff_group_id integer NOT NULL
);


ALTER TABLE public.user_staff_group OWNER TO itorrent;

--
-- Name: jump_page_jump_page_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE jump_page_jump_page_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.jump_page_jump_page_id_seq OWNER TO itorrent;

--
-- Name: jump_page_jump_page_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE jump_page_jump_page_id_seq OWNED BY jump_page.jump_page_id;


--
-- Name: rss_feed_rss_feed_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE rss_feed_rss_feed_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rss_feed_rss_feed_id_seq OWNER TO itorrent;

--
-- Name: rss_feed_rss_feed_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE rss_feed_rss_feed_id_seq OWNED BY rss_feed.rss_feed_id;


--
-- Name: rss_highlight_rss_highlight_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE rss_highlight_rss_highlight_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.rss_highlight_rss_highlight_id_seq OWNER TO itorrent;

--
-- Name: rss_highlight_rss_highlight_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE rss_highlight_rss_highlight_id_seq OWNED BY rss_highlight.rss_highlight_id;


--
-- Name: staff_group_staff_group_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE staff_group_staff_group_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.staff_group_staff_group_id_seq OWNER TO itorrent;

--
-- Name: staff_group_staff_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE staff_group_staff_group_id_seq OWNED BY staff_group.staff_group_id;


--
-- Name: staff_group_staff_permission_staff_group_staff_permission_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE staff_group_staff_permission_staff_group_staff_permission_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.staff_group_staff_permission_staff_group_staff_permission_seq OWNER TO itorrent;

--
-- Name: staff_group_staff_permission_staff_group_staff_permission_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE staff_group_staff_permission_staff_group_staff_permission_seq OWNED BY staff_group_staff_permission.staff_group_staff_permission;


--
-- Name: staff_permission_staff_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE staff_permission_staff_permission_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.staff_permission_staff_permission_id_seq OWNER TO itorrent;

--
-- Name: staff_permission_staff_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE staff_permission_staff_permission_id_seq OWNED BY staff_permission.staff_permission_id;


--
-- Name: torrent_meta_torrent_meta_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE torrent_meta_torrent_meta_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.torrent_meta_torrent_meta_id_seq OWNER TO itorrent;

--
-- Name: torrent_meta_torrent_meta_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE torrent_meta_torrent_meta_id_seq OWNED BY torrent_meta.torrent_meta_id;


--
-- Name: user_staff_group_user_staff_group_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE user_staff_group_user_staff_group_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.user_staff_group_user_staff_group_id_seq OWNER TO itorrent;

--
-- Name: user_staff_group_user_staff_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE user_staff_group_user_staff_group_id_seq OWNED BY user_staff_group.user_staff_group_id;


--
-- Name: user_user_id_seq; Type: SEQUENCE; Schema: public; Owner: itorrent
--

CREATE SEQUENCE user_user_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.user_user_id_seq OWNER TO itorrent;

--
-- Name: user_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: itorrent
--

ALTER SEQUENCE user_user_id_seq OWNED BY "user".user_id;


--
-- Name: jump_page_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE jump_page ALTER COLUMN jump_page_id SET DEFAULT nextval('jump_page_jump_page_id_seq'::regclass);


--
-- Name: rss_feed_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE rss_feed ALTER COLUMN rss_feed_id SET DEFAULT nextval('rss_feed_rss_feed_id_seq'::regclass);


--
-- Name: rss_highlight_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE rss_highlight ALTER COLUMN rss_highlight_id SET DEFAULT nextval('rss_highlight_rss_highlight_id_seq'::regclass);


--
-- Name: staff_group_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE staff_group ALTER COLUMN staff_group_id SET DEFAULT nextval('staff_group_staff_group_id_seq'::regclass);


--
-- Name: staff_group_staff_permission; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE staff_group_staff_permission ALTER COLUMN staff_group_staff_permission SET DEFAULT nextval('staff_group_staff_permission_staff_group_staff_permission_seq'::regclass);


--
-- Name: staff_permission_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE staff_permission ALTER COLUMN staff_permission_id SET DEFAULT nextval('staff_permission_staff_permission_id_seq'::regclass);


--
-- Name: torrent_meta_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE torrent_meta ALTER COLUMN torrent_meta_id SET DEFAULT nextval('torrent_meta_torrent_meta_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE "user" ALTER COLUMN user_id SET DEFAULT nextval('user_user_id_seq'::regclass);


--
-- Name: user_staff_group_id; Type: DEFAULT; Schema: public; Owner: itorrent
--

ALTER TABLE user_staff_group ALTER COLUMN user_staff_group_id SET DEFAULT nextval('user_staff_group_user_staff_group_id_seq'::regclass);


--
-- Name: jump_page_page_slug_key; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY jump_page
    ADD CONSTRAINT jump_page_page_slug_key UNIQUE (page_slug);


--
-- Name: jump_page_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY jump_page
    ADD CONSTRAINT jump_page_pkey PRIMARY KEY (jump_page_id);


--
-- Name: rss_feed_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY rss_feed
    ADD CONSTRAINT rss_feed_pkey PRIMARY KEY (rss_feed_id);


--
-- Name: rss_highlight_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY rss_highlight
    ADD CONSTRAINT rss_highlight_pkey PRIMARY KEY (rss_highlight_id);


--
-- Name: staff_group_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY staff_group
    ADD CONSTRAINT staff_group_pkey PRIMARY KEY (staff_group_id);


--
-- Name: staff_group_staff_permission_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY staff_group_staff_permission
    ADD CONSTRAINT staff_group_staff_permission_pkey PRIMARY KEY (staff_group_staff_permission);


--
-- Name: staff_group_staff_permission_staff_group_id_key; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY staff_group_staff_permission
    ADD CONSTRAINT staff_group_staff_permission_staff_group_id_key UNIQUE (staff_group_id, staff_permission_id);


--
-- Name: staff_permission_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY staff_permission
    ADD CONSTRAINT staff_permission_pkey PRIMARY KEY (staff_permission_id);


--
-- Name: torrent_meta_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY torrent_meta
    ADD CONSTRAINT torrent_meta_pkey PRIMARY KEY (torrent_meta_id);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (user_id);


--
-- Name: user_staff_group_pkey; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY user_staff_group
    ADD CONSTRAINT user_staff_group_pkey PRIMARY KEY (user_staff_group_id);


--
-- Name: user_staff_group_user_id_key; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY user_staff_group
    ADD CONSTRAINT user_staff_group_user_id_key UNIQUE (user_id, staff_group_id);


--
-- Name: user_user_name_key; Type: CONSTRAINT; Schema: public; Owner: itorrent; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_user_name_key UNIQUE (user_name);


--
-- Name: torrent_meta__rss_feed_id; Type: INDEX; Schema: public; Owner: itorrent; Tablespace: 
--

CREATE INDEX torrent_meta__rss_feed_id ON torrent_meta USING btree (rss_feed_id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

