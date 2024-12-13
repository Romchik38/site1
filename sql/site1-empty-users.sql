--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: site1; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE site1 WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.UTF-8';


ALTER DATABASE site1 OWNER TO postgres;

\connect site1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: entities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.entities (
    entity_id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.entities OWNER TO postgres;

--
-- Name: entities_entity_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.entities_entity_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.entities_entity_id_seq OWNER TO postgres;

--
-- Name: entities_entity_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.entities_entity_id_seq OWNED BY public.entities.entity_id;


--
-- Name: entity_field; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.entity_field (
    field_id integer NOT NULL,
    field_name text NOT NULL,
    entity_id integer,
    value text NOT NULL
);


ALTER TABLE public.entity_field OWNER TO postgres;

--
-- Name: entity_field_field_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.entity_field_field_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.entity_field_field_id_seq OWNER TO postgres;

--
-- Name: entity_field_field_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.entity_field_field_id_seq OWNED BY public.entity_field.field_id;


--
-- Name: menu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu (
    menu_id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.menu OWNER TO postgres;

--
-- Name: menu_links; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_links (
    link_id integer NOT NULL,
    name text NOT NULL,
    url text NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.menu_links OWNER TO postgres;

--
-- Name: menu_links_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_links_link_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menu_links_link_id_seq OWNER TO postgres;

--
-- Name: menu_links_link_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menu_links_link_id_seq OWNED BY public.menu_links.link_id;


--
-- Name: menu_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_menu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menu_menu_id_seq OWNER TO postgres;

--
-- Name: menu_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menu_menu_id_seq OWNED BY public.menu.menu_id;


--
-- Name: menu_to_links; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_to_links (
    menu_id integer NOT NULL,
    link_id integer NOT NULL,
    parent_link_id integer DEFAULT 0 NOT NULL,
    priority integer DEFAULT 0 NOT NULL,
    CONSTRAINT do_not_add_zero_link CHECK ((link_id <> 0)),
    CONSTRAINT valid_link CHECK ((link_id <> parent_link_id))
);


ALTER TABLE public.menu_to_links OWNER TO postgres;

--
-- Name: pages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pages (
    page_id integer NOT NULL,
    name text,
    url text,
    content text
);


ALTER TABLE public.pages OWNER TO postgres;

--
-- Name: pages_page_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pages_page_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pages_page_id_seq OWNER TO postgres;

--
-- Name: pages_page_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pages_page_id_seq OWNED BY public.pages.page_id;


--
-- Name: recaptcha; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.recaptcha (
    action text NOT NULL,
    active boolean DEFAULT false NOT NULL
);


ALTER TABLE public.recaptcha OWNER TO postgres;

--
-- Name: recaptcha_google; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.recaptcha_google (
    action text,
    score double precision DEFAULT 0.5 NOT NULL,
    CONSTRAINT check_score CHECK (((score >= (0)::double precision) AND (score <= (1.0)::double precision)))
);


ALTER TABLE public.recaptcha_google OWNER TO postgres;

--
-- Name: recovery_email; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.recovery_email (
    email text NOT NULL,
    hash text NOT NULL,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.recovery_email OWNER TO postgres;

--
-- Name: redirects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.redirects (
    redirect_id integer NOT NULL,
    redirect_from text NOT NULL,
    redirect_to text NOT NULL,
    redirect_code smallint DEFAULT 301,
    redirect_method text DEFAULT 'GET'::text,
    CONSTRAINT method_list CHECK ((redirect_method = ANY (ARRAY['GET'::text, 'POST'::text])))
);


ALTER TABLE public.redirects OWNER TO postgres;

--
-- Name: redirects_redirect_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.redirects_redirect_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.redirects_redirect_id_seq OWNER TO postgres;

--
-- Name: redirects_redirect_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.redirects_redirect_id_seq OWNED BY public.redirects.redirect_id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    user_name text NOT NULL,
    first_name text NOT NULL,
    last_name text NOT NULL,
    password text NOT NULL,
    active boolean DEFAULT false,
    email text NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_user_id_seq OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- Name: entities entity_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entities ALTER COLUMN entity_id SET DEFAULT nextval('public.entities_entity_id_seq'::regclass);


--
-- Name: entity_field field_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entity_field ALTER COLUMN field_id SET DEFAULT nextval('public.entity_field_field_id_seq'::regclass);


--
-- Name: menu menu_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu ALTER COLUMN menu_id SET DEFAULT nextval('public.menu_menu_id_seq'::regclass);


--
-- Name: menu_links link_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_links ALTER COLUMN link_id SET DEFAULT nextval('public.menu_links_link_id_seq'::regclass);


--
-- Name: pages page_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages ALTER COLUMN page_id SET DEFAULT nextval('public.pages_page_id_seq'::regclass);


--
-- Name: redirects redirect_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.redirects ALTER COLUMN redirect_id SET DEFAULT nextval('public.redirects_redirect_id_seq'::regclass);


--
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- Data for Name: entities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.entities (entity_id, name) FROM stdin;
1	Company Site1
2	Html_metadata
\.


--
-- Data for Name: entity_field; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.entity_field (field_id, field_name, entity_id, value) FROM stdin;
1	email_contact_recovery	1	site1@romanenko-studio.dev
2	email_contact_main	1	romanenko@romanenko-studio.dev
3	url_domain	1	https://site1.romanenko-studio.dev
4	url_recovery	1	/changepassword
5	phone_number_text	2	0-800-500-00-xx
6	address_text	2	Mazepy street 10, Kiev, Ukraine
7	notice	2	free from mobile
8	copyrights_text	2	© 2024, Romanenko Studio, LLC.
9	nav_menu_id	2	1
10	default_company	2	1
11	default_layout	2	column1
\.


--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu (menu_id, name) FROM stdin;
1	Main menu
\.


--
-- Data for Name: menu_links; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu_links (link_id, name, url, description) FROM stdin;
0	Parent Link	/parent	Parent link
1	Home	/	Home Page
2	Login	/login/index	Login Page
3	About	/about	About Page
4	Recovery password	/login/recovery	Login recovery password page
5	Login pages	/login	All login pages ( login, recovery, etc)
6	Register new user	/login/register	New users can be registered via this page
7	Change password	/login/changepassword	Registered users can change compromised password on this page
8	Sitemap	/sitemap	All pages are shown here. Visit it to see all in one
\.


--
-- Data for Name: menu_to_links; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu_to_links (menu_id, link_id, parent_link_id, priority) FROM stdin;
1	2	5	0
1	3	0	0
1	4	5	0
1	5	0	100
1	6	5	0
1	7	5	0
\.


--
-- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pages (page_id, name, url, content) FROM stdin;
2	About Page	about	<div class="row mb-3">\n<p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architectodolore laudantiumullam, neque, quas iste eum enim, nihil vitae molestiae quisquam minus iure evenietet ratione porro corrupti quis asperiores.</p><img class="img-fluid mb-3" src="/media/img/our_company.webp" alt="Our company in Kyiv"><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet tenetur temporibusenim laborum possimus, soluta tempore praesentium, reprehenderit, nulla voluptatummagnam facilis distinctio repudiandae sit ullam. Placeat nulla quasi saepe?</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet tenetur temporibusenim laborum possimus, soluta tempore praesentium, reprehenderit, nulla voluptatummagnam facilis distinctio repudiandae sit ullam. Placeat nulla quasi saepe? Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure maiores facilis at enim. Numquam, architecto? Doloribus molestias, laudantium, odio adipisci nulla odit, nemo error eius esse accusantium ullam numquam culpa?</p></div><div class="row justify-content-center"><div class="col-sm-3"><div class="card"><img class="card-img-top" src="/media/img/our_people.webp" alt="Our people"><div class="card-header bg-secondary text-white"><h5 class="card-title text-center ">Head mananger</h5></div><div class="card-body"><p class="card-text">Petro Sagaydachni</p><p class="card-text">Over 20 years of experience in the field of sellingcellular communication devices and implementing new communicationsystems in large companies worldwide</p></div></div></div><div class="col-sm-3"><div class="card"><img class="card-img-top" src="/media/img/our_people_2.webp" alt="Our people"><div class="card-header bg-secondary text-white"><h5 class="card-title text-center ">Chief Financial Officer</h5></div><div class="card-body"><p class="card-text">Olha Denna</p><p class="card-text">With extensive experience in finance, excellentknowledge of modern tools for financial analysis and decision-making,and a background in strategic financial planning accumulated over 15 years</p></div></div></div><div class="col-sm-3"><div class="card"><img class="card-img-top" src="/media/img/our_people_owner.jpg" alt="Our people"><div class="card-header bg-secondary text-white"><h5 class="card-title text-center ">Company owner</h5></div><div class="card-body"><p class="card-text">Andrii Mazepa</p><p class="card-text mb-0">Head of the association of enterprises and organizations of the country. </p><p class="card-text">Successful businessman and professor specializing in financial risks at Economic University.</p></div></div></div></div>
1	Main Page of the site	index	<p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa qu is inventore placeat in illum numquam vitae adipisci? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis reiciendis aperiam, deserunt vel nisi voluptatib us illum exercitationem, expedita, assumenda unde autem in ab quos. Expedita porro alias earum nihil quidem!</p>\n<p>Lorem ipsum dolor, <a href="#">sit amet consectetur</a> adipisicing elit. Nam animi sint provident molestiae voluptate tenetur quae at porro fugit quidem! Repellat culpa quis inventore placeat in illum numquam vitae adipisci?</p>\n<div class="row my-3">\n    <div class="col-sm-6">\n        <img class="img-thumbnail" src="http://picsum.photos/500/500" alt="Some picture">\n    </div>\n    <div class="col-sm-6">\n        <h2>Lorem ipsum dolor sit</h2>\n        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem nostrum voluptatibus velit maxime perspiciatis nihil facilis tempora ullam enim repudiandae! Nihil laborum eaque doloremque facere obcaecati? Ipsam, praesentium quas. Quod? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iure delectus error molestias debitis corrupti fugiat eos repellendus, nostrum, incidunt repudiandae pariatur illo, cupiditate tenetur modi. Voluptatem molestias expedita nisi iure.</p>\n        <button class="btn btn-secondary my-3" type="button">Details</button>\n    </div>\n</div>
\.


--
-- Data for Name: recaptcha; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.recaptcha (action, active) FROM stdin;
login_recovery_emeil_submit	t
\.


--
-- Data for Name: recaptcha_google; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.recaptcha_google (action, score) FROM stdin;
login_recovery_emeil_submit	0.5
\.


--
-- Data for Name: recovery_email; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.recovery_email (email, hash, updated_at) FROM stdin;
\.


--
-- Data for Name: redirects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.redirects (redirect_id, redirect_from, redirect_to, redirect_code, redirect_method) FROM stdin;
1	/index	/	301	GET
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (user_id, user_name, first_name, last_name, password, active, email) FROM stdin;
\.


--
-- Name: entities_entity_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.entities_entity_id_seq', 1, false);


--
-- Name: entity_field_field_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.entity_field_field_id_seq', 11, true);


--
-- Name: menu_links_link_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_links_link_id_seq', 1, false);


--
-- Name: menu_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_menu_id_seq', 1, false);


--
-- Name: pages_page_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pages_page_id_seq', 2, true);


--
-- Name: redirects_redirect_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.redirects_redirect_id_seq', 1, true);


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_user_id_seq', 1, true);


--
-- Name: entities entities_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entities
    ADD CONSTRAINT entities_name_key UNIQUE (name);


--
-- Name: entities entities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entities
    ADD CONSTRAINT entities_pkey PRIMARY KEY (entity_id);


--
-- Name: entity_field entity_field_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entity_field
    ADD CONSTRAINT entity_field_pkey PRIMARY KEY (field_id);


--
-- Name: menu_links menu_links_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_links
    ADD CONSTRAINT menu_links_name_key UNIQUE (name);


--
-- Name: menu_links menu_links_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_links
    ADD CONSTRAINT menu_links_pkey PRIMARY KEY (link_id);


--
-- Name: menu_links menu_links_url_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_links
    ADD CONSTRAINT menu_links_url_key UNIQUE (url);


--
-- Name: menu menu_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu
    ADD CONSTRAINT menu_name_key UNIQUE (name);


--
-- Name: menu menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (menu_id);


--
-- Name: pages pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (page_id);


--
-- Name: pages pages_url_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_url_key UNIQUE (url);


--
-- Name: menu_to_links pk_menu_to_links; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_to_links
    ADD CONSTRAINT pk_menu_to_links PRIMARY KEY (menu_id, link_id, parent_link_id);


--
-- Name: recaptcha recaptcha_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recaptcha
    ADD CONSTRAINT recaptcha_pkey PRIMARY KEY (action);


--
-- Name: recovery_email recovery_email_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recovery_email
    ADD CONSTRAINT recovery_email_pkey PRIMARY KEY (email);


--
-- Name: redirects redirects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.redirects
    ADD CONSTRAINT redirects_pkey PRIMARY KEY (redirect_id);


--
-- Name: redirects redirects_redirect_from_redirect_to_redirect_method_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.redirects
    ADD CONSTRAINT redirects_redirect_from_redirect_to_redirect_method_key UNIQUE (redirect_from, redirect_to, redirect_method);


--
-- Name: entity_field unique_entity_field; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entity_field
    ADD CONSTRAINT unique_entity_field UNIQUE (field_name, entity_id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: users users_user_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_user_name_key UNIQUE (user_name);


--
-- Name: entity_field entity_field_entity_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entity_field
    ADD CONSTRAINT entity_field_entity_id_fkey FOREIGN KEY (entity_id) REFERENCES public.entities(entity_id) ON DELETE CASCADE;


--
-- Name: menu_to_links menu_to_links_link_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_to_links
    ADD CONSTRAINT menu_to_links_link_id_fkey FOREIGN KEY (link_id) REFERENCES public.menu_links(link_id) ON DELETE CASCADE;


--
-- Name: menu_to_links menu_to_links_menu_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_to_links
    ADD CONSTRAINT menu_to_links_menu_id_fkey FOREIGN KEY (menu_id) REFERENCES public.menu(menu_id) ON DELETE CASCADE;


--
-- Name: menu_to_links menu_to_links_parent_link_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_to_links
    ADD CONSTRAINT menu_to_links_parent_link_id_fkey FOREIGN KEY (parent_link_id) REFERENCES public.menu_links(link_id) ON DELETE CASCADE;


--
-- Name: recaptcha_google recaptcha_google_action_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recaptcha_google
    ADD CONSTRAINT recaptcha_google_action_fkey FOREIGN KEY (action) REFERENCES public.recaptcha(action) ON DELETE CASCADE;


--
-- Name: recovery_email recovery_email_email_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.recovery_email
    ADD CONSTRAINT recovery_email_email_fkey FOREIGN KEY (email) REFERENCES public.users(email) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

