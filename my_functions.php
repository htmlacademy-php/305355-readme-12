<?php
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
?>