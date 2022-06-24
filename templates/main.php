<div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                  <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                      <a class="filters__button filters__button--ellipse filters__button--all <?= $content_type_id ? '' : 'filters__button--active' ?>" href="index.php">
                          <span>Все</span>
                      </a>
                  </li>
                  <?php foreach ($content_types as $index => $content_type): ?>
                    <li class="popular__filters-item filters__item">
                        <a
                          class="filters__button <?= ($content_type_id == $content_type['id']) ? 'filters__button--active' : '' ?> filters__button--<?= $content_type['name']; ?> button"
                          href="index.php?content_type_id=<?= $content_type['id']; ?>"
                        >
                            <span class="visually-hidden"><?= $content_type['title']; ?></span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-<?= $content_type['name']; ?>"></use>
                            </svg>
                        </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $index => $post): ?>
                <article class="popular__post post post-<?= $post['content_type'] ?>">
                    <header class="post__header">
                        <h2><a href="post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']); ?></a></h2>
                    </header>
                    <div class="post__main">
                        <!--здесь содержимое карточки-->
                        <?php switch ($post['content_type']):
                          case 'quote': ?>
                            <blockquote>
                                <p>
                                    <?= htmlspecialchars($post['text_content']); ?>
                                </p>
                                <cite><?= htmlspecialchars($post['quote_author']); ?></cite>
                            </blockquote>
                        <?php break; ?>
                        
                        <?php case 'link': ?>  
                            <!--содержимое для поста-ссылки-->
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="http://<?= htmlspecialchars($post['page_src']); ?>" title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?= htmlspecialchars($post['title']); ?></h3>
                                        </div>
                                    </div>
                                    <span><?= htmlspecialchars($post['page_src']); ?></span>
                                </a>
                            </div>
                        <?php break; ?>

                        <?php case 'photo': ?>
                            <!--содержимое для поста-фото-->
                            <div class="post-photo__image-wrapper">
                                <img src="<?= $post['image_src']; ?>" alt="Фото от пользователя <?= $post['user_name']; ?>" width="360" height="240">
                            </div>
                        <?php break; ?>

                        <?php case 'video': ?>
                            <!--содержимое для поста-видео-->
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <?=embed_youtube_cover(htmlspecialchars($post['video_src'])); ?>
                                    <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">
                                </div>
                                <a href="post-details.html" class="post-video__play-big button">
                                    <svg class="post-video__play-big-icon" width="14" height="14">
                                        <use xlink:href="#icon-video-play-big"></use>
                                    </svg>
                                    <span class="visually-hidden">Запустить проигрыватель</span>
                                </a>
                            </div>
                        <?php break; ?>

                        <?php case 'text': ?>
                            <!--содержимое для поста-текста-->
                            <?= limit_text(htmlspecialchars($post['text_content'])); ?>
                        <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="#" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img
                                      class="post__author-avatar"
                                      src="<?= $post['avatar']; ?>"
                                      alt="Аватар пользователя <?= htmlspecialchars($post['user_name']); ?>"
                                    >
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><?= htmlspecialchars($post['user_name']); ?></b>
                                    <?php $random_date = generate_random_date($index); ?>
                                    <?php $date_interval = date_diff(date_create($random_date), date_create("now")); ?>
                                    <time
                                      class="post__time"
                                      datetime="<?= $random_date ?>"
                                      title="<?= date_format(date_create($random_date), "d.m.Y H:i") ?>"
                                    >
                                      <?= get_interval_description($date_interval) ?>
                                    </time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>