CREATE TABLE buildings
(
  id           INTEGER PRIMARY KEY    NOT NULL,
  city         VARCHAR(255)           NOT NULL,
  street       VARCHAR(255)           NOT NULL,
  build_number DOUBLE PRECISION       NOT NULL,
  location     GEOGRAPHY(POINT, 4326) NOT NULL
);

CREATE TABLE categories
(
  id        INTEGER PRIMARY KEY              NOT NULL,
  name      VARCHAR(255)                     NOT NULL,
  type      SMALLINT DEFAULT '1' :: SMALLINT NOT NULL, -- branch or leaf --
  _lft      INTEGER                          NOT NULL,
  _rgt      INTEGER                          NOT NULL,
  parent_id INTEGER
);

CREATE TABLE companies
(
  id       INTEGER PRIMARY KEY NOT NULL,
  build_id INTEGER             NOT NULL,
  name     VARCHAR(255)        NOT NULL,
  phones   JSONB               NOT NULL
);

-- Many to Many --
CREATE TABLE company_category_pivot
(
  company_id  INTEGER NOT NULL,
  category_id INTEGER NOT NULL
);

CREATE INDEX location_gix ON buildings (location);
CREATE INDEX categories__lft__rgt_parent_id_index ON categories (_lft, _rgt, parent_id);
ALTER TABLE companies ADD FOREIGN KEY (build_id) REFERENCES buildings (id);
ALTER TABLE company_category_pivot ADD FOREIGN KEY (company_id) REFERENCES companies (id);
ALTER TABLE company_category_pivot ADD FOREIGN KEY (category_id) REFERENCES categories (id);
