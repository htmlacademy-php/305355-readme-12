<?php

  $post_data_map = [
    'text-heading' => 'title',
    'quote-heading' => 'title',
    'photo-heading' => 'title',
    'video-heading' => 'title',
    'link-heading' => 'title',
    'post-text' => 'text_content',
    'cite-text' => 'text_content',
    'photo-url' => 'image_src',
    'video-url' => 'video_src',
    'link-url' => 'page_src',
    'quote-author' => 'quote_author',
    // 'userpic-file-photo' => 'Изображение',
  ];

  function print_error_and_exit($con) {
    $error = mysqli_error($con);
    print('Ошибка запроса: ' . $error);
    exit();
  }

  function get_result($con, $query) {
    $result = mysqli_query($con, $query);

    if (!$result) {
      print_error_and_exit($con);
    }

    return $result;
  }

  function get_content_types($con) {
    $content_types_query = 'SELECT * FROM content_types';
    $content_types_result = get_result($con, $content_types_query);
    $content_types = mysqli_fetch_all($content_types_result, MYSQLI_ASSOC);

    return $content_types;
  }

  function get_posts($con, $content_type_id) {
    $posts_query = $content_type_id ?
      'SELECT p.id AS id, p.title AS title, text_content, avatar, video_src, image_src, page_src, quote_author, u.name AS user_name, ct.name AS content_type
        FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id
        WHERE ct.id = ' . $content_type_id . ' ORDER BY p.views_amount DESC'
      :
      'SELECT p.id AS id, p.title AS title, text_content, avatar, video_src, image_src, page_src, quote_author, u.name AS user_name, ct.name AS content_type
        FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id
        ORDER BY p.views_amount DESC';

    $posts_result = get_result($con, $posts_query);
    $posts = mysqli_fetch_all($posts_result, MYSQLI_ASSOC);

    return $posts;
  }

  function get_post($con, $id) {
    $post_query = 'SELECT *, u.id AS user_id, u.name AS user_name, u.avatar AS user_avatar,
      ct.name AS content_type, p.title AS post_title FROM posts p
      JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id
      WHERE p.id = ' . $id;
    $post_result = get_result($con, $post_query);
    $post = mysqli_fetch_assoc($post_result);

    return $post;
  }

  function get_user_subscriptions($con, $post) {
    $user_subscriptions_query = 'SELECT COUNT(s.follower_id) AS followers_count FROM users u
      LEFT JOIN subscriptions s ON u.id = s.user_id
      WHERE u.id = ' . $post['user_id'];
    $user_subscriptions_result = get_result($con, $user_subscriptions_query);
    $user_subscriptions = mysqli_fetch_assoc($user_subscriptions_result);

    return $user_subscriptions;
  }

  function get_user_posts($con, $post) {
    $user_posts_query = 'SELECT COUNT(p.id) AS posts_count FROM users u
      LEFT JOIN posts p ON u.id = p.user_id
      WHERE u.id = ' . $post['user_id'];
    $user_posts_result = get_result($con, $user_posts_query);
    $user_posts = mysqli_fetch_assoc($user_posts_result);

    return $user_posts;
  }

  function create_post($con, $data) {
    global $post_data_map;
    $user_id = rand(1, 3);
    $hashtag_ids = [];
    $entities = [];
    $values = [];

    $content_type_query = 'SELECT * FROM content_types WHERE name = ' . '\'' . $data['content_type_key'] . '\'';
    $content_type_result = get_result($con, $content_type_query);
    $content_type = mysqli_fetch_assoc($content_type_result);

    $content_type_id = $content_type['id'];

    foreach ($data as $key => $item) {
      if ($key == 'hashtags') {
        foreach ($item as $hashtag_title) {
          $hashtag_query = 'SELECT * FROM hashtags WHERE title = ' . '\'' . $hashtag_title . '\'';
          $hastag_result = get_result($con, $hashtag_query);
          $hashtag = mysqli_fetch_assoc($hastag_result);

          if ($hashtag) {
            array_push($hashtag_ids, $hashtag['id']);
          } else {
            $insert_hashtag_query = 'INSERT INTO hashtags SET title = ' . '\'' . $hashtag_title . '\'';
            $insert_hastag_result = get_result($con, $insert_hashtag_query);

            if ($insert_hastag_result) {
              $last_hashtag_query = 'SELECT * FROM hashtags ORDER BY id DESC LIMIT 1';
              $last_hashtag_result = get_result($con, $last_hashtag_query);
              $last_hashtag = mysqli_fetch_assoc($last_hashtag_result);

              array_push($hashtag_ids, $last_hashtag['id']);
            }
          }
        }
      } else if ($key !== 'content_type_key') {
        $entities[] = $post_data_map[$key];
        $values[] = '\'' . $item . '\'';
      }
    }
    
    $entities_string = implode(', ', $entities);
    $values_string = implode(', ', $values);
    
    $insert_post_query = "INSERT INTO posts (user_id, content_type_id, {$entities_string})
      VALUES ({$user_id}, {$content_type_id}, {$values_string})";
    $insert_post_result = get_result($con, $insert_post_query);
    
    if ($insert_post_result) {
      $last_post_query = 'SELECT * FROM posts ORDER BY id DESC LIMIT 1';
      $last_post_result = get_result($con, $last_post_query);
      $last_post = mysqli_fetch_assoc($last_post_result);

      foreach ($hashtag_ids as $h_id) {
        $insert_post_hashtags_query = "INSERT INTO post_hashtags (post_id, hashtag_id) 
          VALUES ({$last_post['id']}, {$h_id})";
        $insert_post_hashtags_result = get_result($con, $insert_post_hashtags_query);

        if (!$insert_post_hashtags_result) {
          return;
        }
      }
    }
  }
?>