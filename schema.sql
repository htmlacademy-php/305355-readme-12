CREATE DATABASE readme
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE users (
  id INT AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(320) NOT NULL UNIQUE,
  password CHAR(128) NOT NULL,
  avatar VARCHAR(255),
  PRIMARY KEY (id)
);

CREATE TABLE hashtags (
  id INT AUTO_INCREMENT,
  title VARCHAR(128) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE content_types (
  id INT AUTO_INCREMENT,
  title VARCHAR(128),
  class_name CHAR(128),
  PRIMARY KEY (id)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT,
  create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(128) NOT NULL,
  text_content TEXT,
  quote_author VARCHAR(255),
  image_src VARCHAR(255),
  video_src VARCHAR(255),
  page_src VARCHAR(255),
  views_amount INT,
  user_id INT,
  content_type_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (content_type_id) REFERENCES content_types(id)
);

CREATE TABLE comments (
  id INT AUTO_INCREMENT,
  text_content TEXT NOT NULL,
  author_id INT,
  post_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE likes (
  id INT AUTO_INCREMENT,
  user_id INT,
  post_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE subscriptions (
  id INT AUTO_INCREMENT,
  user_id INT,
  follower_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT,
  create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  text_content TEXT NOT NULL,
  sender_id  INT,
  receiver_id  INT,
  PRIMARY KEY (id),
  FOREIGN KEY (sender_id) REFERENCES users(id),
  FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE post_hashtags (
  id INT AUTO_INCREMENT,
  post_id INT,
  hashtag_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (hashtag_id) REFERENCES hashtags(id) ON DELETE CASCADE
);
