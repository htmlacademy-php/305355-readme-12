CREATE DATABASE readme
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE urt8_general_ci;

USE readme;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128) NOT NULL,
  email CHAR(128) NOT NULL UNIQUE,
  password CHAR(64) NOT NULL,
  avatar CHAR(128)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  title CHAR(128) NOT NULL,
  text_content CHAR(256),
  author_name CHAR(128),
  image_src CHAR(128),
  vide_src CHAR(128),
  page_src CHAR(128),
  views_amount INT,
  user_id INT FOREIGN KEY,
  content_type CHAR(64) FOREIGN KEY,
  hashtag_id INT FOREIGN KEY
);

CREATE TABLE commentaries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  text_content CHAR(256) NOT NULL,
  author_id INT FOREIGN KEY,
  post_id INT FOREIGN KEY
);

CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT FOREIGN KEY,
  post_id INT FOREIGN KEY
);

CREATE TABLE subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT FOREIGN KEY,
  follower_id INT FOREIGN KEY
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  text_content CHAR(256) NOT NULL,
  sender_id  INT FOREIGN KEY,
  receiver_id  INT FOREIGN KEY
);

CREATE TABLE hastags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title CHAR(64) NOT NULL
);

CREATE TABLE content_types (
  -- вот тут не понял
);
