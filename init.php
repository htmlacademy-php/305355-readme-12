<?php

$is_auth = rand(0, 1);
$user_name = 'Oleg';

$con = mysqli_connect('localhost', 'root', 'root', 'readme');

if (!$con) {
  print('Ошибка подключения: ' . mysqli_connect_error());
  exit();
}

mysqli_set_charset($con, 'utf8');

?>