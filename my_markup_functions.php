<?php

function get_field_title ($field_name) {
  if (in_array($field_name, array('text-heading', 'quote-heading', 'photo-heading', 'video-heading', 'link-heading'))) {
    return 'Заголовок';
  }
  if (in_array($field_name, array('text-tags', 'quote-tags', 'photo-tags', 'video-tags', 'link-tags'))) {
    return 'Тэги';
  }
  
  $field_title_map = [
    'post-text' => 'Текст поста',
    'cite-text' => 'Текст цитаты',
    'photo-url' => 'Ссылка из интернета',
    'video-url' => 'Ссылка youtube',
    'link-url' => 'Ссылка',
    'quote-author' => 'Автор',
    'userpic-file-photo' => 'Изображение',
  ];

  return $field_title_map[$field_name];
}

function get_dimensions_by_content_type($content_type) {
  switch ($content_type) {
    case 'photo':
      return ['width' => '22', 'height' => '18'];
    case 'video':
      return ['width' => '24', 'height' => '16'];
    case 'text':
      return ['width' => '20', 'height' => '21'];
    case 'quote':
      return ['width' => '21', 'height' => '20'];
    case 'link':
      return ['width' => '21', 'height' => '18'];
    default:
      return ['width' => '0', 'height' => '0'];
  }
}

function get_link_title($content_type) {
  switch ($content_type) {
    case 'photo':
      return 'Ссылка из интернета';
    case 'video':
      return 'Ссылка youtube';
    case 'link':
      return 'Ссылка';
  }
}

function getPostVal($name) {
  return isset($_POST[$name]) ? trim($_POST[$name]) : '';
}

?>