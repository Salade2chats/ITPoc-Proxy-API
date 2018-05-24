create database itpoc_proxy;

create user itpoc_proxy with encrypted password 'Riding on the storm!';

grant all privileges on database "itpoc_proxy" to itpoc_proxy;


-- Drop table

-- DROP TABLE public."users"

CREATE TABLE IF NOT EXISTS public."users" (
	id uuid NOT NULL,
	email varchar NOT NULL,
	password char(60) NOT NULL,
	token varchar NOT NULL,
	creation_date timestamp without time zone NOT NULL DEFAULT NOW(),
	CONSTRAINT users_pk PRIMARY KEY (id),
	CONSTRAINT users_email_unique UNIQUE (email),
	CONSTRAINT users_token_unique UNIQUE (token)
)
WITH (
	OIDS=FALSE
) ;
CREATE UNIQUE INDEX users_email_idx ON public."users" (email) ;
CREATE UNIQUE INDEX users_token_idx ON public."users" (token) ;
COMMENT ON TABLE public."users" IS 'Users' ;
GRANT ALL ON TABLE public."users" TO itpoc_proxy;

-- Column comments

COMMENT ON COLUMN public."users".id IS 'Primary ID' ;
COMMENT ON COLUMN public."users".email IS 'User email' ;
COMMENT ON COLUMN public."users".password IS 'User password' ;
COMMENT ON COLUMN public."users".token IS 'User token' ;
COMMENT ON COLUMN public."users".creation_date IS 'User creation date' ;



-- Drop table

-- DROP TABLE public."domains"

CREATE TABLE IF NOT EXISTS public."domains" (
	id uuid NOT NULL,
	domain varchar NOT NULL,
	creation_date timestamp without time zone NOT NULL DEFAULT NOW(),
	CONSTRAINT domains_pk PRIMARY KEY (id),
	CONSTRAINT domains_domain_unique UNIQUE (domain)
)
WITH (
	OIDS=FALSE
) ;
CREATE UNIQUE INDEX domains_domain_idx ON public."domains" (domain) ;
COMMENT ON TABLE public."domains" IS 'Domains' ;
GRANT ALL ON TABLE public."domains" TO itpoc_proxy;

-- Column comments
COMMENT ON COLUMN public."domains".id IS 'Primary ID' ;
COMMENT ON COLUMN public."domains".domain IS 'Domain (SLD.TLD)' ;
COMMENT ON COLUMN public."domains".creation_date IS 'Domain creation date' ;



-- Drop table

-- DROP TABLE public."sub_domain"

CREATE TABLE IF NOT EXISTS public.sub_domains (
  id uuid NOT NULL,
	sub_domain varchar NOT NULL,
	creation_date timestamp without time zone NOT NULL DEFAULT NOW(),
	user_id uuid NOT NULL,
	domain_id uuid NOT NULL,
	CONSTRAINT sub_domains_pk PRIMARY KEY (id),
	CONSTRAINT sub_domains_sub_domain_domain_unique UNIQUE (domain_id, sub_domain),
	CONSTRAINT sub_domains_domain_fk FOREIGN KEY (domain_id) REFERENCES public."domains"(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT sub_domains_user_fk FOREIGN KEY (user_id) REFERENCES public."users"(id) ON DELETE CASCADE ON UPDATE CASCADE
)
WITH (
	OIDS=FALSE
) ;
COMMENT ON TABLE public.sub_domains IS 'Users sub-domains' ;
GRANT ALL ON TABLE public."sub_domains" TO itpoc_proxy;

-- Column comments
COMMENT ON COLUMN public."sub_domains".id IS 'Primary ID' ;
COMMENT ON COLUMN public."sub_domains".sub_domain IS 'Sub-domain' ;
COMMENT ON COLUMN public."sub_domains".domain_id IS 'Foreign key to domain' ;
COMMENT ON COLUMN public."sub_domains".user_id IS 'Foreign key to user' ;
COMMENT ON COLUMN public."sub_domains".creation_date IS 'Sub-domain creation date' ;