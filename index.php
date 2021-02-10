<?php

require_once('helpers.php');
require_once('my_functions.php');

$is_auth = rand(0, 1);

$user_name = 'Oleg'; // укажите здесь ваше имя

$posts = [
  [
    'title' => 'Цитата',	
    'type' => 'post-quote',	
    'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
    'name' => 'Лариса',
    'avatar' => 'userpic-larisa-small.jpg',
  ],
  [
    'title' => 'Игра престолов',
    'type' => 'post-text',
    'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
    'name' => 'Владик',
    'avatar' => 'userpic.jpg',
  ],
  [
    'title' => 'Наконец, обработал фотки!',
    'type' => 'post-photo',
    'content' => 'rock-medium.jpg',
    'name' => 'Виктор',
    'avatar' => 'userpic-mark.jpg',
  ],
  [
    'title' => 'Моя мечта',
    'type' => 'post-photo',
    'content' => 'coast-medium.jpg',
    'name' => 'Лариса',
    'avatar' => 'userpic-larisa-small.jpg',
  ],
  [
    'title' => 'Лучшие курсы',
    'type' => 'post-link',
    'content' => 'www.htmlacademy.ru',
    'name' => 'Владик',
    'avatar' => 'userpic.jpg',
  ],
];



$main_content = include_template('main.php', ['posts' => $posts]);
$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'main_content' => $main_content,
    'page_title' => "readme: популярное",
  ]
);
echo $layout;
?>
