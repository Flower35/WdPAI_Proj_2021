
DROP TABLE IF EXISTS public.languages;
CREATE TABLE public.languages (
  lang_id serial4 NOT NULL,
  code varchar(3) NOT NULL,
  "name" varchar(10) NOT NULL,
  CONSTRAINT languages_code_key UNIQUE (code),
  CONSTRAINT languages_name_key UNIQUE (name),
  CONSTRAINT languages_pkey PRIMARY KEY (lang_id)
);

DROP TABLE IF EXISTS public.translation_short;
CREATE TABLE public.translation_short (
  text_id serial4 NOT NULL,
  shortname varchar(32) NOT NULL,
  CONSTRAINT translation_short_pkey PRIMARY KEY (text_id),
  CONSTRAINT translation_short_shortname_key UNIQUE (shortname)
);

DROP TABLE IF EXISTS public.translation_text;
CREATE TABLE public.translation_text (
  text_id int4 NOT NULL,
  lang_id int4 NOT NULL,
  "text" varchar(255) NOT NULL,
  CONSTRAINT translation_text_pkey PRIMARY KEY (text_id, lang_id)
);

DROP TABLE IF EXISTS public.users;
CREATE TABLE public.users (
  user_id serial4 NOT NULL,
  superpowers bool NOT NULL,
  activated bool NOT NULL,
  created timestamp NOT NULL,
  email varchar(255) NOT NULL,
  "password" varchar(255) NOT NULL,
  display_name varchar(255) NOT NULL,
  "language" int4 NULL,
  last_note int4 NULL,
  CONSTRAINT users_email_key UNIQUE (email),
  CONSTRAINT users_pkey PRIMARY KEY (user_id)
);

INSERT INTO public.languages (code,"name") VALUES
  ('pol','Polski'),
  ('eng','English');

INSERT INTO public.translation_short (shortname) VALUES
  ('TITLE_LOGIN'),
  ('TITLE_REGISTER'),
  ('TITLE_SETTINGS'),
  ('TITLE_BROWSE'),
  ('TITLE_EDIT'),
  ('ERROR_LOGIN_MAIL'),
  ('ERROR_LOGIN_PASS'),
  ('ERROR_REGISTER_HUMAN'),
  ('ERROR_REGISTER_EMAIL'),
  ('ERROR_REGISTER_PASS'),
  ('ERROR_REGISTER_PASSMISS'),
  ('ERROR_REGISTER_EXISTS'),
  ('ERROR_REGISTER_ANYTHING'),
  ('SUCCESS_REGISTER'),
  ('SESSION_REQUIRED'),
  ('SESSION_EXPIRED'),
  ('SUCCESS_LOGOFF'),
  ('FORM_MAIL'),
  ('FORM_PASS'),
  ('FORM_PASS2'),
  ('FORM_NEWNAME'),
  ('FORM_NEWPASS'),
  ('FORM_ROBOT'),
  ('FORM_BTN_LOGIN'),
  ('FORM_BTN_REGISTER'),
  ('FORM_BTN_UPDATE'),
  ('FORM_BTN_REMOVE'),
  ('HOME_QUESTION'),
  ('NAVMENU_SETTINGS'),
  ('NAVMENU_LOGOFF'),
  ('UPDATE_USERNAME_SUCCESS'),
  ('UPDATE_USERNAME_FAIL'),
  ('UPDATE_USERPASS_SUCCESS'),
  ('UPDATE_USERPASS_FAIL'),
  ('REMOVE_USER_FAIL');

INSERT INTO public.translation_text (text_id,lang_id,"text") VALUES
  (1,1,'Logowanie do serwisu'),
  (1,2,'Login to website'),
  (2,1,'Rejestracja użytkownika'),
  (2,2,'User registration'),
  (3,1,'Ustawienia użytkownika'),
  (3,2,'User settings'),
  (4,1,'Przeglądanie notatek'),
  (4,2,'Browsing notes'),
  (5,1,'Edycja notatki'),
  (5,2,'Note editing'),
  (6,1,'Użytkownik "{}" nie istnieje!'),
  (6,2,'User "{}" not found!'),
  (7,1,'Niewłaściwe hasło dla "{}".'),
  (7,2,'Incorrect password for "{}".'),
  (8,1,'Nie jesteś człowiekiem. Odejdź.'),
  (8,2,'You are not a human. Go away.'),
  (9,1,'Proszę podać adres e-mail!'),
  (9,2,'Please provide an e-mail address!'),
  (10,1,'Proszę podać hasło!'),
  (10,2,'Please provide a password!'),
  (11,1,'Hasła nie pasują do siebie! Spróbuj ponownie.'),
  (11,2,'Password mismatch! Try again.'),
  (12,1,'Przepraszamy, użytkownik "{}" już istnieje.'),
  (12,2,'Sorry, user "{}" already exists.'),
  (13,1,'Przepraszamy, nie udało się dodać użytkownika do bazy!'),
  (13,2,'Sorry, could not add user to the database!'),
  (14,1,'Pomyślnie zarejestrowano konto! :)'),
  (14,2,'Successfully registered account! :)'),
  (15,1,'Musisz być zalogowany, aby mieć dostęp do tej strony.'),
  (15,2,'You must be logged in in order to acces this site.'),
  (16,1,'Sesja wygasła. Zaloguj się ponownie.'),
  (16,2,'Session has expired. Log in again.'),
  (17,1,'Wylogowano pomyślnie.'),
  (17,2,'Logged off successfully.'),
  (18,1,'adres e-mail'),
  (18,2,'e-mail address'),
  (19,1,'hasło'),
  (19,2,'password'),
  (20,1,'powtórz hasło'),
  (20,2,'repeat password'),
  (21,1,'nowa nazwa wyświetlana'),
  (21,2,'new display name'),
  (22,1,'nowe hasło'),
  (22,2,'new password'),
  (23,1,'Nie jestem robotem'),
  (23,2,'I am not a robot'),
  (24,1,'Zaloguj się'),
  (24,2,'Log in'),
  (25,1,'Zarejestruj konto'),
  (25,2,'Register account'),
  (26,1,'Zaatualizuj'),
  (26,2,'Update'),
  (27,1,'Zniszcz konto'),
  (27,2,'Destroy account'),
  (28,1,'Nie masz jeszcze konta?'),
  (28,2,'Don''t you have an account yet?'),
  (29,1,'Ustawienia'),
  (29,2,'Settings'),
  (30,1,'Wyloguj się'),
  (30,2,'Log off'),
  (31,1,'Zaaktualizowano twoją nazwę wyświetlaną na "{}".'),
  (31,2,'Updated your display name to "{}".'),
  (32,1,'Nie udało się zaaktualizować twojej nazwy wyświetlanej!'),
  (32,2,'Failed to update your display name!'),
  (33,1,'Zaaktualizowano twoje hasło.'),
  (33,2,'Updated your password.'),
  (34,1,'Nie udało się zaaktualizować twojego hasła!'),
  (34,2,'Failed to update your password!'),
  (35,1,'Nie udało się usunąć użytkownika ({}) "{}"!'),
  (35,2,'Could not remove user ({}) "{}"!');

INSERT INTO public.users (superpowers,activated,created,email,"password",display_name,"language",last_note) VALUES
  (false,true,'2022-02-15 18:47:18','gosc@cata.log','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3','Gość',NULL,NULL),
  (true,true,'2022-02-15 19:26:31','admin@cata.log','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','Administrator',NULL,NULL);
