-- create database cms_udemy;
\c cms_udemy;

-- create table categories(
--   id SERIAL NOT NULL PRIMARY KEY,
--   title text
-- );

-- insert into categories (title) values ('Bootstrap'), ('JavaScript');

-- create table posts(
--   id SERIAL NOT NULL PRIMARY KEY,
--   title varchar(255),
--   body text,
--   author varchar(255),
--   image text,
--   category_id integer,
--   created_at timestamp,
--   updated_at timestamp
-- );

alter table posts
add post_tags varchar(255),
add post_comment_count varchar(255),
add post_status varchar(255) default 'draft'
;
