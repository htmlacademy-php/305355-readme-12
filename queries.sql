-- добавление списка типов контента для поста;
INSERT INTO content_types (title, name) VALUES ('Текст', 'text');
INSERT INTO content_types (title, name) VALUES ('Цитата', 'quote');
INSERT INTO content_types (title, name) VALUES ('Картинка', 'photo');
INSERT INTO content_types (title, name) VALUES ('Видео', 'video');
INSERT INTO content_types (title, name) VALUES ('Ссылка', 'link');

-- добавлений пользователей
INSERT INTO users (name, email, password, avatar) VALUES ('Валерий Игоревич', 'valera@site.ru', 123, 'img/userpic-larisa-small.jpg');
INSERT INTO users (name, email, password, avatar) VALUES ('Дмитрий', 'dmitriy@dmitriy.site', 122333, 'img/userpic.jpg');
INSERT INTO users (name, email, password, avatar) VALUES ('table_man', 'table@man.site', 0, 'img/userpic-mark.jpg');

-- добавление постов
INSERT INTO posts (user_id, content_type_id, title, text_content, quote_author, views_amount)
  VALUES (1, 2, 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Неизвестный автор', 5);
INSERT INTO posts (user_id, content_type_id, title, text_content, views_amount)
  VALUES (2, 1, 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', 3);
INSERT INTO posts (user_id, content_type_id, title, image_src, views_amount)
  VALUES (1, 3, 'Наконец, обработал фотки!', 'img/userpic.jpg', 17);
INSERT INTO posts (user_id, content_type_id, title, image_src, views_amount)
  VALUES (2, 3, 'Моя мечта', 'img/coast-medium.jpg', 28);
INSERT INTO posts (user_id, content_type_id, title, page_src, views_amount)
  VALUES (1, 5, 'Лучшие курсы', 'www.htmlacademy.ru', 1);

-- добавление комментариев
INSERT INTO comments (author_id, post_id, text_content) VALUES (1, 2, 'Ух ты! ВОоот это да!');
INSERT INTO comments (author_id, post_id, text_content) VALUES (1, 2, 'Djn "nj htfkmyj bynthtcyj!');
INSERT INTO comments (author_id, post_id, text_content) VALUES (1, 3, 'Чё к чему я чёт нипонял');
INSERT INTO comments (author_id, post_id, text_content) VALUES (2, 5, 'Кто-нибудь уже смотрел этот фидьм?');

-- получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента
SELECT p.title AS post_title, ct.title AS content_type, u.name AS user_name FROM posts p
  JOIN content_types ct ON p.content_type_id = ct.id JOIN users u ON p.user_id = u.id ORDER BY p.views_amount ASC;

-- получить список постов для конкретного пользователя
SELECT title AS post_title FROM posts WHERE user_id = 1;

-- получить список комментариев для одного поста, в комментариях должен быть логин пользователя
SELECT c.text_content AS comment, u.name AS user_name FROM comments c 
  JOIN users u ON c.author_id = u.id WHERE c.post_id = 2;

-- добавить лайк к посту
INSERT INTO likes (user_id, post_id) VALUES (2, 2);

-- подписаться на пользователя
INSERT INTO subscriptions (user_id, follower_id) VALUES (1, 2);
INSERT INTO subscriptions (user_id, follower_id) VALUES (1, 3);
