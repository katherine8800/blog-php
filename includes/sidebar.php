<div class="block grid__item grid__item--1w">
  <h2 class="block__title">THE NEWEST ARTICLES</h2>
  <div class="block__content">

    <ul class="a-list">
      <?php
      $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `id` DESC limit 12");
      ?>
      <?php
      while ($art = mysqli_fetch_assoc($articles)) {
      ?>
      <li class="a-list__item">
        <a href="/article.php?id=<?php echo $art['id']; ?>" class="a-list__link">
          <span class="a-list__time"><?php echo date("d.m.Y", strtotime($art['pubdate'])); ?></span>
          <span class="a-list__title"><?php echo mb_substr(strip_tags($art['title']), 0, 35, 'utf-8'); ?></span>
        </a>
      </li>

      <?php
      } ?>

    </ul>
    <a href="/articles.php?order=id" class="block__all-link">All articles</a>
  </div>
</div>