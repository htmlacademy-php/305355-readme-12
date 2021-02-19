<?php
  require_once('helpers.php');

  /**
   * Возвращает урезанную строку, если строка длиннее некоторого числа
   * @param string $text Полная строка
   * @param int $max_symbols Число, ограничивающее количество символов
   * @return string HTML с полной или урезанной строкой
   */
  function limit_text ($text, $max_symbols=300) {
    $words = explode(' ', $text);
    $first_words = [];
    $words_length = 0;
    $is_more_than_max_symbols = false;

    foreach ($words as $word) {
      $words_length += mb_strlen($word) + 1;
      $first_words[] = $word;

      if ($words_length - 1 >= $max_symbols) {
        $is_more_than_max_symbols = true;
        break;
      }
    }

    return $is_more_than_max_symbols ? 
      '<p>' . implode(' ', $first_words) . '...</p><a class="post-text__more-link" href="#">Читать далее</a>' : '<p>' . $text . '</p>';
  }

  /**
   * Возвращает промежуток времени с момента публикации поста
   * @param object $date_interval объект типа DateInterval
   * @return string строка с указанным промежутком времени
   */
  function get_interval_description ($date_interval) {
    $description = "";

    switch (true) {
      case (($date_interval->d >= 7 * 5) || ($date_interval->m > 0)):
        $noun_plural_form = get_noun_plural_form($date_interval->m, 'месяц', 'месяца', 'месяцев');
        $description = "$date_interval->m $noun_plural_form назад";
        break;
      case (($date_interval->d >= 7) && ($date_interval->d < 5 * 7)):
        $weeks_amount = floor($date_interval->d / 7);
        $noun_plural_form = get_noun_plural_form($weeks_amount, 'неделя', 'недели', 'недель');
        $description = "$weeks_amount $noun_plural_form назад";
        break;
      case ($date_interval->d > 0):
        $noun_plural_form = get_noun_plural_form($date_interval->d, 'день', 'дня', 'дней');
        $description = "$date_interval->d $noun_plural_form назад";
        break;
      case ($date_interval->h > 0):
        $noun_plural_form = get_noun_plural_form($date_interval->h, 'час', 'часа', 'часов');
        $description = "$date_interval->h $noun_plural_form назад";
        break;
      case ($date_interval->i > 0):
        $noun_plural_form = get_noun_plural_form($date_interval->i, 'минута', 'минуты', 'минут');
        $description = "$date_interval->i $noun_plural_form назад";
        break;
    }

    return $description;
  }
?>