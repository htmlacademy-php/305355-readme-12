CREATE DATABASE readme
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE users (
  id INT AUTO_INCREMENT,
  name CHAR(128) NOT NULL,
  email CHAR(128) NOT NULL UNIQUE,
  password CHAR(64) NOT NULL,
  avatar CHAR(128),
  PRIMARY KEY (id)
);

CREATE TABLE hashtags (
  id INT AUTO_INCREMENT,
  title CHAR(64) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE content_types (
  id INT AUTO_INCREMENT,
  title ENUM('Текст', 'Цитата', 'Картинка', 'Видео', 'Ссылка'),
  class_name ENUM('photo', 'video', 'text', 'quote', 'link'),
  PRIMARY KEY (id)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT,
  create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  title CHAR(128) NOT NULL,
  text_content TEXT,
  author_name CHAR(128),
  image_src CHAR(128),
  video_src CHAR(128),
  page_src CHAR(128),
  views_amount INT,
  user_id INT,
  content_type_id INT,
  hashtag_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (content_type_id) REFERENCES content_types(id),
  FOREIGN KEY (hashtag_id) REFERENCES hashtags(id)
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
  FOREIGN KEY (user_id) REFERENCES users(id),
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
