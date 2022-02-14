XD

Users (
  user_id      SERIAL PRIMARY KEY NOT NULL,
  superpowers  BOOL               NOT NULL,
  activated    BOOL               NOT NULL,
  created      TIMESTAMP          NOT NULL,
  email        VARCHAR(255)       NOT NULL UNIQUE,
  password     VARCHAR(255)       NOT NULL,
  display_name VARCHAR(255)       NOT NULL,
  language     INT,
  last_note    INT
);

Languages (
  lang_id  SERIAL PRIMARY KEY NOT NULL,
  code     VARCHAR(3)         NOT NULL UNIQUE,
  name     VARCHAR(10)        NOT NULL UNIQUE
);

Translation_Short (
  text_id    SERIAL PRIMARY KEY NOT NULL,
  shortname  VARCHAR(32)        NOT NULL UNIQUE
);

Translation_Text (
  text_id     INT          NOT NULL,
  lang_id     INT          NOT NULL,
  text        VARCHAR(255) NOT NULL,
  PRIMARY KEY (text_id, lang_id)
);

Notes (
  note_id    SERIAL PRIMARY KEY NOT NULL,
  user_id    INT                NOT NULL,
  icon_color INT                NOT NULL,
  bkg_color  INT                NOT NULL,
  fnt_color  INT                NOT NULL,
  created    TIMESTAMP          NOT NULL,
  modified   TIMESTAMP          NOT NULL,
  expires    TIMESTAMP,
  name       VARCHAR(255)       NOT NULL
);

NoteHeaders (
  noteheader_id SERIAL PRIMARY KEY NOT NULL,
  note_id       INT                NOT NULL,
  col_order     INT                NOT NULL,
  name          VARCHAR(255)       NOT NULL
);

Notes_NoteRows (
  noterow_id SERIAL PRIMARY KEY NOT NULL,
  note_id    INT                NOT NULL,
  row_order  INT                NOT NULL
);

NoteFields_Placement (
  noteheader_id  INT  NOT NULL,
  noterow_id     INT  NOT NULL,
  notefield_id   INT  NOT NULL,
  PRIMARY KEY (noterow_id, notefield_id)
);

NoteFields (
  notefield_id  SERIAL PRIMARY KEY NOT NULL,
  bkg_color     INT                NOT NULL,
  fnt_color     INT                NOT NULL,
  value         TEXT               NOT NULL
);
