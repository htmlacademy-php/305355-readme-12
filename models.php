<?php

  function print_error_and_exit($con) {
    $error = mysqli_error($con);
    print('Ошибка запроса: ' . $error);
    exit();
  }

  function get_content_types($con) {
    $content_types_sql = 'SELECT * FROM content_types';
    $content_types_result = mysqli_query($con, $content_types_sql);

    if (!$content_types_result) {
      print_error_and_exit($con);
    }

    $content_types = mysqli_fetch_all($content_types_result, MYSQLI_ASSOC);

    return $content_types;
  }

  function get_posts($con, $content_type_id) {$posts_sql = $content_type_id ?
    'SELECT p.id AS id, p.title AS title, text_content, avatar, video_src, image_src, page_src, quote_author, u.name AS user_name, ct.class_name AS content_type
      FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id WHERE ct.id = ' . $content_type_id . ' ORDER BY p.views_amount DESC'
    :
    'SELECT p.id AS id, p.title AS title, text_content, avatar, video_src, image_src, page_src, quote_author, u.name AS user_name, ct.class_name AS content_type
      FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id ORDER BY p.views_amount DESC';
  
    $posts_result = mysqli_query($con, $posts_sql);

    if (!$posts_result) {
      print_error_and_exit($con);
    }

    $posts = mysqli_fetch_all($posts_result, MYSQLI_ASSOC);

    return $posts;
  }

  function get_post($con, $id) {
    $post_sql = 'SELECT *, u.id AS user_id, u.name AS user_name, u.avatar AS user_avatar,
      ct.class_name AS content_type, p.title AS post_title
      FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id
      WHERE p.id = ' . $id;
    $post_result = mysqli_query($con, $post_sql);

    if (!$post_result) {
      print_error_and_exit($con);
    }

    $post = mysqli_fetch_assoc($post_result);

    return $post;
  }

  function get_user_subscriptions($con, $post) {
    $user_subscriptions_sql = 'SELECT COUNT(s.follower_id) AS followers_count FROM users u
      LEFT JOIN subscriptions s ON u.id = s.user_id
      WHERE u.id = ' . $post['user_id'];
    $user_subscriptions_result = mysqli_query($con, $user_subscriptions_sql);

    if (!$user_subscriptions_result) {
      print_error_and_exit($con);
    }

    $user_subscriptions = mysqli_fetch_assoc($user_subscriptions_result);

    return $user_subscriptions;
  }

  function get_user_posts($con, $post) {
    $user_posts_sql = 'SELECT COUNT(p.id) AS posts_count FROM users u
      LEFT JOIN posts p ON u.id = p.user_id
      WHERE u.id = ' . $post['user_id'];
    $user_posts_result = mysqli_query($con, $user_posts_sql);

    if (!$user_posts_result) {
      print_error_and_exit($con);
    }

    $user_posts = mysqli_fetch_assoc($user_posts_result);

    return $user_posts;
  }

?>