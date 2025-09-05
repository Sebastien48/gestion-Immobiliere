--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5
-- Dumped by pg_dump version 17.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: SCHEMA "public"; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA "public" IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = "heap";

--
-- Name: agences; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."agences" (
    "numero" character varying(255) NOT NULL,
    "nomAgence" character varying(255) NOT NULL,
    "fondateur" character varying(255) NOT NULL,
    "emailAgence" character varying(255) NOT NULL,
    "adresse" character varying(255) NOT NULL,
    "telephoneAgence" character varying(255) NOT NULL,
    "logo" character varying(255),
    "document" character varying(255),
    "id" bigint NOT NULL,
    "created_at" timestamp(0) without time zone,
    "updated_at" timestamp(0) without time zone
);


--
-- Name: agences_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "public"."agences_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: agences_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "public"."agences_id_seq" OWNED BY "public"."agences"."id";


--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."cache" (
    "key" character varying(255) NOT NULL,
    "value" "text" NOT NULL,
    "expiration" integer NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."cache_locks" (
    "key" character varying(255) NOT NULL,
    "owner" character varying(255) NOT NULL,
    "expiration" integer NOT NULL
);


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."failed_jobs" (
    "id" bigint NOT NULL,
    "uuid" character varying(255) NOT NULL,
    "connection" "text" NOT NULL,
    "queue" "text" NOT NULL,
    "payload" "text" NOT NULL,
    "exception" "text" NOT NULL,
    "failed_at" timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "public"."failed_jobs_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "public"."failed_jobs_id_seq" OWNED BY "public"."failed_jobs"."id";


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."job_batches" (
    "id" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "total_jobs" integer NOT NULL,
    "pending_jobs" integer NOT NULL,
    "failed_jobs" integer NOT NULL,
    "failed_job_ids" "text" NOT NULL,
    "options" "text",
    "cancelled_at" integer,
    "created_at" integer NOT NULL,
    "finished_at" integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."jobs" (
    "id" bigint NOT NULL,
    "queue" character varying(255) NOT NULL,
    "payload" "text" NOT NULL,
    "attempts" smallint NOT NULL,
    "reserved_at" integer,
    "available_at" integer NOT NULL,
    "created_at" integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "public"."jobs_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "public"."jobs_id_seq" OWNED BY "public"."jobs"."id";


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."migrations" (
    "id" integer NOT NULL,
    "migration" character varying(255) NOT NULL,
    "batch" integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "public"."migrations_id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "public"."migrations_id_seq" OWNED BY "public"."migrations"."id";


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."password_reset_tokens" (
    "email" character varying(255) NOT NULL,
    "token" character varying(255) NOT NULL,
    "created_at" timestamp(0) without time zone
);


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."sessions" (
    "id" character varying(255) NOT NULL,
    "user_id" character varying(255),
    "ip_address" character varying(45),
    "user_agent" "text",
    "payload" "text" NOT NULL,
    "last_activity" integer NOT NULL
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "public"."users" (
    "code" character varying(5) NOT NULL,
    "nom" character varying(255) NOT NULL,
    "prenom" character varying(255) NOT NULL,
    "telephone" character varying(255) NOT NULL,
    "nomAgence" character varying(255) NOT NULL,
    "role" character varying(255) DEFAULT 'utilisateur'::character varying NOT NULL,
    "email" character varying(255) NOT NULL,
    "password" character varying(255) NOT NULL,
    "numero" character varying(255) NOT NULL,
    "created_at" timestamp(0) without time zone,
    "updated_at" timestamp(0) without time zone
);


--
-- Name: agences id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."agences" ALTER COLUMN "id" SET DEFAULT "nextval"('"public"."agences_id_seq"'::"regclass");


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."failed_jobs" ALTER COLUMN "id" SET DEFAULT "nextval"('"public"."failed_jobs_id_seq"'::"regclass");


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."jobs" ALTER COLUMN "id" SET DEFAULT "nextval"('"public"."jobs_id_seq"'::"regclass");


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."migrations" ALTER COLUMN "id" SET DEFAULT "nextval"('"public"."migrations_id_seq"'::"regclass");


--
-- Data for Name: agences; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('AGR : 21-00012', 'kouadio', 'vianney', 'vianney@gmail.com', '16 rue de canabière', '555107312', 'agences/logos/Vu2ogzOFDt5qtwqaV1keSoaxcm6xo5ibdNb3H35G.png', 'agences/documents/ZFAGfV2QpEFDYh6mDpFkHeBZVzsnjUYh5sKXQLPu.png', 1, '2025-08-06 16:57:29', '2025-08-06 16:57:29');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('AGR : N° 13-0014', 'V2X', 'medard', 'medard@gmail.com', '16 rue de canabière', '555107312', 'agences/logos/V2j3MgxCM9Xvl7IuT50VFV4FjAkuLRvpBjzbgqEz.png', 'agences/documents/fiQoodac6WSIqsfweaWvnrX8md83vsCkgY56qE3s.png', 2, '2025-08-06 17:05:18', '2025-08-06 17:05:18');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('N°2567ATUY', 'ZOOMX', 'KONATE ZANGA', 'zangafc@gmail.com', 'houston, usa', '+1485796523', 'agences/logos/reMABT9k4u3l7BroYSRIRtlL728qVFXm0ifkTjOO.png', 'agences/documents/DmKcLKDyUDSbfVjeA2vF5CUqR8bVwPCKvUpe3lBj.png', 3, '2025-08-06 17:13:29', '2025-08-06 17:13:29');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('N°225784563ZERTY', 'RTX', 'saint-pierre', 'pierre@gmail.com', '16 rue française, france', '+7 78278666', 'agences/logos/S5yJMsEmxlX9608Xja9Xm7adLCr82OZENAEvcQdC.png', 'agences/documents/2nLpqt1HApAg2FaAahMAEeKbc5q2fxwT8cVo9g72.png', 4, '2025-08-06 17:15:40', '2025-08-06 17:15:40');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('N°22578456af', 'erkra', 'sanchan', 'yuri@gmail.com', 'cocody,abidjan,côte d''ivoire', '555107312', 'agences/logos/9aocUiL4o1FW22hhD1CpahGwsIXPi9gIt9O7nw8q.png', 'agences/documents/egAyXYsjVa0stMItOmGKzZFRNHMGC6e2OiUsjfeF.png', 5, '2025-08-06 17:17:14', '2025-08-06 17:17:14');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('zaerky', 'MKPI', 'kanepierre', 'kousso@gmail.com', '14 rue saint valley', '555107312', 'agences/logos/eUomo8fvruIMwbu03nmxIiFPuy4mW5CHCq3A1TPo.png', 'agences/documents/5gnKku2h6I629yBlL5fTouG7ermm2GNifwSf7fp6.png', 6, '2025-08-07 11:13:59', '2025-08-07 11:13:59');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('N°22578456trente', 'kirikou', 'loicje', 'loeuihe@gmail.com', 'loi78,fezvzh', '+82 684655485', 'agences/logos/ce9DPCxQOaaLkbM8tP6YwA923RouX3AqytpZPyfr.png', 'agences/documents/540kNeFR6F2VQ9404PKxZYZK8vTOeBzvo69dtFky.png', 7, '2025-08-07 12:03:51', '2025-08-07 12:03:51');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('25678po', 'ekise', 'guvihv', 'hcgvcuui@gmail.com', '16 rue de canabière', '555107312', 'agences/logos/u4cfxdCT3ekPCxzLlXEThW8WWoDTnSVs2QyWlx78.png', 'agences/documents/T8OZy0RkfUIC322bG1ld3igPu7K20jfIoqDUQUzw.png', 8, '2025-08-07 13:57:40', '2025-08-07 13:57:40');
INSERT INTO "public"."agences" ("numero", "nomAgence", "fondateur", "emailAgence", "adresse", "telephoneAgence", "logo", "document", "id", "created_at", "updated_at") VALUES ('lomzebefz78', 'frenand', '74pmabubzi', 'zzam@gmail.com', '78,rue parisienne', '+7 98564854', 'agences/logos/q5ZPMLOndaFmGRTBNordGJXezXZr2v3MewPQr6Wf.png', 'agences/documents/Rq7NsdZ0NSUzVSrrkIXLSIv1Fi1MHLUiafalgoF5.png', 9, '2025-08-07 19:40:38', '2025-08-07 19:40:38');


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "public"."migrations" ("id", "migration", "batch") VALUES (6, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO "public"."migrations" ("id", "migration", "batch") VALUES (7, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO "public"."migrations" ("id", "migration", "batch") VALUES (8, '2025_08_05_101158_create_agences_table', 1);
INSERT INTO "public"."migrations" ("id", "migration", "batch") VALUES (9, '0001_01_01_000000_create_users_table', 2);


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "public"."sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES ('5BzFavkcqQLfdXO8TBDO2iKzaSDh10LBEBfOp4Js', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSENqS0hPcDJ5MXlydWg2dmgza2FYVHA2aXNDeDdKYkRFb2Q1TmE4VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1754644792);
INSERT INTO "public"."sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES ('izpRrb0t5LTb6ULNOTHsrR4kM9qBzkQOfnISf8lr', 'CVMLI', '192.168.100.25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia3pSMGd1QVJSY0JUMDlRSExqczNKMmNmeVBlTFN5Yk9GNDB2Y2VnYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly8xOTIuMTY4LjEwMC4yNTo4MDAwL2FnZW5jZS1pbW1ib2xpJUMzJUE4cmUvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6NToiQ1ZNTEkiO30=', 1754644274);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "public"."users" ("code", "nom", "prenom", "telephone", "nomAgence", "role", "email", "password", "numero", "created_at", "updated_at") VALUES ('DXHKA', 'vianney', 'kouadio', '555107312', 'kouadio', 'utilisateur', 'vianney@gmail.com', '$2y$12$18vMI8QqPQOBe2HsyGtgWezJm.fvh8zWNNYS.P/AqhxdQ3p832TpW', 'AGR : 21-00012', '2025-08-06 18:33:53', '2025-08-06 18:33:53');
INSERT INTO "public"."users" ("code", "nom", "prenom", "telephone", "nomAgence", "role", "email", "password", "numero", "created_at", "updated_at") VALUES ('3WTQG', 'vianney', 'kouadio', '555107312', 'ZOOMX', 'utilisateur', 'karnouvianneykouadio@gmail.com', '$2y$12$fqHrOQuXYKdw7F.Hk0hEfuvtjp69sxpkr4oUF2mRIUueryMSbkKxq', 'N°2567ATUY', '2025-08-06 18:56:43', '2025-08-06 18:56:43');
INSERT INTO "public"."users" ("code", "nom", "prenom", "telephone", "nomAgence", "role", "email", "password", "numero", "created_at", "updated_at") VALUES ('KVBA4', 'esnest', 'vrimidi', '055542158', 'RTX', 'utilisateur', 'vrimidi@gmail.com', '$2y$12$bnkpHd9a25WqNbLWGm0P.OI2Xa3xBavcSsfqV88v9b3qqBVND0zdi', 'N°225784563ZERTY', '2025-08-06 19:11:25', '2025-08-06 19:11:25');
INSERT INTO "public"."users" ("code", "nom", "prenom", "telephone", "nomAgence", "role", "email", "password", "numero", "created_at", "updated_at") VALUES ('53SUW', 'zanga', 'cssi', '+255 01 51417858', 'erkra', 'administrateur', 'konatezanga@gmail.com', '$2y$12$snXT1C49rDUPyCRQWh.0SOQ0JFu3bpLFe9HnTkTei9SGXrpRhAfp.', 'N°22578456af', '2025-08-06 19:14:23', '2025-08-06 19:14:23');
INSERT INTO "public"."users" ("code", "nom", "prenom", "telephone", "nomAgence", "role", "email", "password", "numero", "created_at", "updated_at") VALUES ('KFSDE', 'sassuke', 'uchiwa', '+30 410257896', 'frenand', 'utilisateur', 'uxhiwa21@gmail.com', '$2y$12$4wsy4DH3mICibyV8x7Y6s.swxXKe7Ta74WgK6xwaIdJw0b8wprKDG', 'lomzebefz78', '2025-08-07 21:42:41', '2025-08-07 21:42:41');
INSERT INTO "public"."users" ("code", "nom", "prenom", "telephone", "nomAgence", "role", "email", "password", "numero", "created_at", "updated_at") VALUES ('87H9P', 'loic', 'jean', '+33 555107312', 'kirikou', 'administrateur', 'loic@gmail.com', '$2y$12$fqqdx88gcgxbn/NQEHAPmOQaRyfZt3aAParvld3TC0bp.dZhLgviy', 'N°22578456trente', '2025-08-07 21:40:06', '2025-08-07 21:40:06');
INSERT INTO "public"."users" ("code", "nom", "prenom", "telephone", "nomAgence", "role", "email", "password", "numero", "created_at", "updated_at") VALUES ('CVMLI', 'bonzou', 'eric', '+ 4 526535865356', 'ekise', 'utilisateur', 'eric@gmail.com', '$2y$12$k/wu2FHtSDQtah0D7si.9.dVapWiHTywzhDi9JLm3zenGKK3tCmyW', '25678po', '2025-08-08 08:55:01', '2025-08-08 08:55:01');


--
-- Name: agences_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"public"."agences_id_seq"', 9, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"public"."failed_jobs_id_seq"', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"public"."jobs_id_seq"', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('"public"."migrations_id_seq"', 9, true);


--
-- Name: agences agences_emailagence_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."agences"
    ADD CONSTRAINT "agences_emailagence_unique" UNIQUE ("emailAgence");


--
-- Name: agences agences_logo_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."agences"
    ADD CONSTRAINT "agences_logo_unique" UNIQUE ("logo");


--
-- Name: agences agences_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."agences"
    ADD CONSTRAINT "agences_pkey" PRIMARY KEY ("numero");


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."cache_locks"
    ADD CONSTRAINT "cache_locks_pkey" PRIMARY KEY ("key");


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."cache"
    ADD CONSTRAINT "cache_pkey" PRIMARY KEY ("key");


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."failed_jobs"
    ADD CONSTRAINT "failed_jobs_pkey" PRIMARY KEY ("id");


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."failed_jobs"
    ADD CONSTRAINT "failed_jobs_uuid_unique" UNIQUE ("uuid");


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."job_batches"
    ADD CONSTRAINT "job_batches_pkey" PRIMARY KEY ("id");


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."jobs"
    ADD CONSTRAINT "jobs_pkey" PRIMARY KEY ("id");


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."migrations"
    ADD CONSTRAINT "migrations_pkey" PRIMARY KEY ("id");


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."password_reset_tokens"
    ADD CONSTRAINT "password_reset_tokens_pkey" PRIMARY KEY ("email");


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."sessions"
    ADD CONSTRAINT "sessions_pkey" PRIMARY KEY ("id");


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."users"
    ADD CONSTRAINT "users_email_unique" UNIQUE ("email");


--
-- Name: users users_numero_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."users"
    ADD CONSTRAINT "users_numero_unique" UNIQUE ("numero");


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."users"
    ADD CONSTRAINT "users_pkey" PRIMARY KEY ("code");


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "jobs_queue_index" ON "public"."jobs" USING "btree" ("queue");


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "sessions_last_activity_index" ON "public"."sessions" USING "btree" ("last_activity");


--
-- Name: users users_numero_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "public"."users"
    ADD CONSTRAINT "users_numero_foreign" FOREIGN KEY ("numero") REFERENCES "public"."agences"("numero") ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

