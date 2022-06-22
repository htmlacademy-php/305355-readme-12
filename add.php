<?php
// phpinfo();
require_once('helpers.php');
require_once('my_functions.php');
require_once('my_markup_functions.php');
require_once('init.php');
require_once('models.php');

$content_type_key = $_POST['content-type-key'] ?? 'text';

$required_fields = [
  'text' => ['text-heading', 'post-text'],
  'quote' => ['quote-heading', 'cite-text', 'quote-author'],
  'photo' => ['photo-heading'],
  'video' => ['video-heading', 'video-url'],
  'link' => ['link-heading', 'link-url'],
];
$errors = [];
$data = [
  'content_type_key' => $content_type_key,
];

foreach ($required_fields[$content_type_key] as $field) {
  if (empty($_POST[$field])) {
    $errors[$field] = [
      'title' => get_field_title($field),
      'description' => 'Это поле должно быть заполнено',
    ];
  } else {
    $data[$field] = $_POST[$field];
  }
}

if (($content_type_key === 'photo') && empty($_POST['photo-url']) && empty($_FILES['userpic-file-photo']['name'])) {
  $errors['photo-url'] = [
    'title' => get_field_title('photo-url'),
    'description' => 'Добавьте изображение либо ссылку на него',
  ];
  $errors['userpic-file-photo'] = [
    'title' => get_field_title('userpic-file-photo'),
    'description' => 'Добавьте изображение либо ссылку на него',
  ];
}

if (!empty($_POST[$content_type_key . '-tags'])) {
  $tags = explode(' ', $_POST[$content_type_key . '-tags']);
  $data['hashtags'] = [];

  foreach($tags as $tag) {
    $is_incorrect_tag = $tag && ((strlen($tag) === 1) || (substr($tag, 0, 1) !== '#'));

    if ($is_incorrect_tag) {
      $errors[$content_type_key . '-tags'] = [
        'title' => get_field_title($content_type_key . '-tags'),
        'description' => 'Исправьте некорректные теги',
      ];
      break;
    }
    if ($tag) {
      array_push($data['hashtags'], $tag);
    }
  }
}

if (isset($_FILES['userpic-file-photo'])) {
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $file_name = $_FILES['userpic-file-photo']['tmp_name'];

  if ($file_name) {
    $file_type = finfo_file($finfo, $file_name);
    $image_file_types = ['image/gif', 'image/png', 'image/jpeg'];
  
    if (!in_array($file_type, $image_file_types)) {
      $errors['userpic-file-photo'] = [
        'title' => get_field_title('userpic-file-photo'),
        'description' => 'Некорректный формат изображения',
      ];
    }
  }
}

if (!empty($_POST['photo-url'])) {
  if (!filter_var($_POST['photo-url'], FILTER_VALIDATE_URL)) {
    $errors['photo-url'] = [
      'title' => get_field_title('photo-url'),
      'description' => 'Некорректная ссылка на изображение',
    ];
  } else {
    $file = file_get_contents($_POST['photo-url']);
  
    if (!$file) {
      $errors['photo-url'] = [
        'title' => get_field_title('photo-url'),
        'description' => 'Не найдено изображение по данной ссылке',
      ];
    } else {
      $data['photo-url'] = $_POST['photo-url'];
    }
  }
}

if (!empty($_POST['video-url'])) {
  if (!filter_var($_POST['video-url'], FILTER_VALIDATE_URL)) {
    $errors['video-url'] = [
      'title' => get_field_title('video-url'),
      'description' => 'Некорректная ссылка на видео',
    ];
  } else {
    $check_video = check_youtube_url($_POST['video-url']);

    if ($check_video !== true) {
      $errors['video-url'] = [
        'title' => get_field_title('video-url'),
        'description' => $check_video,
      ];
    } else {
      $data['video-url'] = $_POST['video-url'];
    }
  }
}

$has_errors = isset($errors) && count($errors);
if (!$has_errors) {
  create_post($con, $data);
  header("Location: index.php");
}
$content_types = get_content_types($con);

// $form_blocks = [
//   'heading' => include_template('add-post/heading.php'),
//   'tags' => include_template('add-post/tags.php'),
//   'submit' => include_template('add-post/submit.php'),
//   'error' => include_template('add-post/error.php')
// ];


$main_content = include_template('add-post.php', [
    'content_types' => $content_types,
    'content_type_key' => $content_type_key,
    'errors' => isset($_POST['content-type-key']) ? $errors : [],
  ]
);
$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'main_content' => $main_content,
    'page_title' => 'readme: популярное',
  ]
);
echo $layout;

?>
