<?php
  require_once('my_markup_functions.php');
?>

<main class="page__main page__main--adding-post">
<div class="page__main-section">
  <div class="container">
    <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
  </div>
  <div class="adding-post container">
    <div class="adding-post__tabs-wrapper tabs">
      <div class="adding-post__tabs filters">
        <ul class="adding-post__tabs-list filters__list tabs__list">

          <?php foreach($content_types as $content_type): ?>
            <?php $dimensions = get_dimensions_by_content_type($content_type['name']); ?>
            <li class="adding-post__tabs-item filters__item">
              <a
                class= "adding-post__tabs-link filters__button
                  filters__button--<?=$content_type['name']?> tabs__item button
                  <?= ($content_type['name'] === $content_type_key) ? 'filters__button--active tabs__item--active' : '' ?>"
              > 
                <svg class="filters__icon" width="<?=$dimensions['width']?>" height="<?=$dimensions['height']?>">
                  <use xlink:href="#icon-filter-<?=$content_type['name']?>"></use>
                </svg>
                <span><?=$content_type['title']?></span>
              </a>
            </li>
          <?php endforeach; ?>

        </ul>
      </div>

<!--   -----------------------------------------------------   -->
<!--   -----------------------------------------------------   -->
<!--   -----------------------------------------------------   -->
      <div class="adding-post__tab-content">

        <?php foreach($content_types as $content_type): ?>
          <?php
            // var_dump($content_type_key);
            $heading_error = isset($errors[$content_type_key . '-heading']) ?
              $errors[$content_type_key . '-heading'] : null;
            $url_error = isset($errors[$content_type_key . '-url']) ?
              $errors[$content_type_key . '-url'] : null;
            $post_text_error = isset($errors['post-text']) ?
              $errors['post-text'] : null;
            $cite_text_error = isset($errors['cite-text']) ?
              $errors['cite-text'] : null;
            $quote_author_error = isset($errors['quote-author']) ?
              $errors['quote-author'] : null;
            $tags_error = isset($errors[$content_type_key . '-tags']) ?
              $errors[$content_type_key . '-tags'] : null;
          ?>

          <section class="adding-post__<?= $content_type_key ?> tabs__content
            <?= ($content_type['name'] === $content_type_key) ? 'tabs__content--active' : ''; ?>"
          >
            <h2 class="visually-hidden">Форма добавления <?= $content_type['title'] ?></h2>
            <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
              <div class="form__text-inputs-wrapper">
                <div class="form__text-inputs">

                  <!-- Заголовок -----------------------------------------------------   -->

                  <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="<?= $content_type['name'] ?>-heading">
                      Заголовок <span class="form__input-required">*</span>
                    </label>
                    <div class="form__input-section
                      <?= $heading_error ? 'form__input-section--error' : '' ?>"
                    >
                      <input
                        class="adding-post__input form__input"
                        id="<?= $content_type['name'] ?>-heading"
                        type="text"
                        name="<?= $content_type['name'] ?>-heading"
                        value="<?= getPostVal($content_type['name'] . '-heading'); ?>"
                        placeholder="Введите заголовок"
                      >
                      <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                      <div class="form__error-text">
                        <h3 class="form__error-title">
                          <?= $heading_error ? $heading_error['title'] : '' ?>
                        </h3>
                        <p class="form__error-desc">
                          <?= $heading_error ? $heading_error['description'] : '' ?>
                        </p>
                      </div>
                    </div>
                  </div>

                <!-- Ссылка  -----------------------------------------------------   -->

                  <?php if (in_array($content_type['name'], array('photo', 'video', 'link'))): ?>
                    <div class="adding-post__input-wrapper form__input-wrapper">
                      <label class="adding-post__label form__label" for="<?= $content_type['name'] ?>-url">
                        <?= get_link_title($content_type['name']) ?>
                        <?php if ($content_type['name'] !== 'photo'): ?> <span class="form__input-required">*</span> <?php endif; ?>
                      </label>
                      <div class="form__input-section
                        <?= $url_error ? 'form__input-section--error' : '' ?>"
                      >
                        <input
                          class="adding-post__input form__input"
                          id="<?= $content_type['name'] ?>-url"
                          type="text"
                          name="<?= $content_type['name'] ?>-url"
                          value="<?= getPostVal($content_type['name'] . '-url'); ?>"
                          placeholder="Введите ссылку"
                        >
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                          <h3 class="form__error-title">
                            <?= $url_error ? $url_error['title'] : '' ?>
                          </h3>
                          <p class="form__error-desc">
                            <?= $url_error ? $url_error['description'] : '' ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>

                <!-- Текст поста -----------------------------------------------------   -->

                <?php if ($content_type['name'] === 'text'): ?>
                  <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                    <label class="adding-post__label form__label" for="post-text">
                      Текст поста <span class="form__input-required">*</span>
                    </label>
                    <div class="form__input-section
                      <?= $post_text_error ? 'form__input-section--error' : '' ?>"
                    >
                      <textarea
                        class="adding-post__textarea form__textarea form__input"
                        id="post-text"
                        name="post-text"
                        placeholder="Введите текст публикации"
                      ><?= getPostVal('post-text'); ?></textarea>
                      <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                      <div class="form__error-text">
                        <h3 class="form__error-title">
                          <?= $post_text_error ? $post_text_error['title'] : '' ?>
                        </h3>
                        <p class="form__error-desc">
                          <?= $post_text_error ? $post_text_error['description'] : '' ?>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

                <!--   -----------------------------------------------------   -->
                  
                <!-- Текст цитаты и Автор -----------------------------------------------------   -->

                <?php if ($content_type['name'] === 'quote'): ?>
                  <div class="adding-post__input-wrapper form__textarea-wrapper">
                    <label class="adding-post__label form__label" for="cite-text">
                      Текст цитаты <span class="form__input-required">*</span>
                    </label>
                    <div class="form__input-section
                      <?= $cite_text_error ? 'form__input-section--error' : '' ?>"
                    >
                      <textarea
                        class="adding-post__textarea adding-post__textarea--quote form__textarea form__input"
                        id="cite-text"
                        name="cite-text"
                        placeholder="Текст цитаты"
                      ><?= getPostVal('cite-text'); ?></textarea>
                      <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                      <div class="form__error-text">
                        <h3 class="form__error-title">
                          <?= $cite_text_error ? $heading_error['title'] : '' ?>
                        </h3>
                        <p class="form__error-desc">
                          <?= $cite_text_error ? $heading_error['title'] : '' ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="adding-post__textarea-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="quote-author">
                      Автор <span class="form__input-required">*</span>
                    </label>
                    <div class="form__input-section
                      <?= $quote_author_error ? 'form__input-section--error' : '' ?>"
                    >
                      <input
                        class="adding-post__input form__input"
                        id="quote-author"
                        type="text"
                        name="quote-author"
                        value="<?= getPostVal('quote-author'); ?>"
                        placeholder="Введите Имя Автора"
                      >
                      <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                      <div class="form__error-text">
                        <h3 class="form__error-title">
                          <?= $quote_author_error ? $quote_author_error['title'] : '' ?>
                        </h3>
                        <p class="form__error-desc">
                          <?= $quote_author_error ? $quote_author_error['description'] : '' ?>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

                <!-- Теги  -----------------------------------------------------   -->

                  <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="<?= $content_type['name'] ?>-tags">
                      Теги
                    </label>
                    <div class="form__input-section
                      <?= $tags_error ? 'form__input-section--error' : '' ?>"
                    >
                      <input
                        class="adding-post__input form__input"
                        id="<?= $content_type['name'] ?>-tags"
                        type="text"
                        name="<?= $content_type['name'] ?>-tags"
                        value="<?= getPostVal($content_type['name'] . '-tags'); ?>"
                        placeholder="Введите теги"
                      >
                      <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                      <div class="form__error-text">
                        <h3 class="form__error-title">
                          <?= $tags_error ? $tags_error['title'] : '' ?>
                        </h3>
                        <p class="form__error-desc">
                          <?= $tags_error ? $tags_error['description'] : '' ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if (!empty($errors)): ?>
                  <div class="form__invalid-block">
                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                    <ul class="form__invalid-list">
                      <?php foreach($errors as $error): ?>
                        <!-- <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li> -->
                        <li class="form__invalid-item"><?= $error['title'] ?>. <?= $error['description'] ?>.</li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>
              </div>

              <?php if ($content_type['name'] === 'photo'): ?>
                <div class="adding-post__input-file-container form__input-container form__input-container--file">
                  <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                    <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                      <input
                        class="adding-post__input-file form__input-file"
                        id="userpic-file-photo"
                        type="file"
                        name="userpic-file-photo"
                        title=" "
                      >
                      <div class="form__file-zone-text">
                        <span>Перетащите фото сюда</span>
                      </div>
                    </div>
                    <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                      <span>Выбрать фото</span>
                      <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                        <use xlink:href="#icon-attach"></use>
                      </svg>
                    </button>
                  </div>
                  <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                  </div>
                </div>
              <?php endif; ?>

              <input type="hidden" name="content-type-key" value="<?= $content_type['name']; ?>">

              <div class="adding-post__buttons">
                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                <a class="adding-post__close" href="#">Закрыть</a>
              </div>
            </form>
          </section>
        <?php endforeach; ?>
<!--   -----------------------------------------------------   -->
<!--   -----------------------------------------------------   -->
<!--   -----------------------------------------------------   -->
        
      </div>
    </div>
  </div>
</div>
</main>
