<?php
require  "includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link href="css/libs/hamburgers.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/styles.min.css" />
  <title><?php echo $config['title']; ?></title>
</head>

<body>


  <?php
  include "includes/header.php"
  ?>

  <main>
    <section class="section">
      <div class="container">
        <h1 class="main-title">Just a Journal</h1>

        <div class="grid">
          <div class="block grid__item grid__item--2w w3 m-right">
            <h2 class="block__title">TOP ARTICLES</h2>
            <div class="block__content">
              <a href="/articles.php" class="block__all-link">All articles</a>
              <?php
              $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `views` DESC limit 4");
              ?>
              <?php
              // while ($art = mysqli_fetch_assoc($articles)) {
                foreach($articles as $art) {
              ?>
              <a href="/article.php?id=<?php echo $art['id']; ?>" class="preview">
                <div class="preview__img-wrap">
                  <img src="<?php echo $art['image']; ?>" alt="" class="preview__img">
                </div>
                <div class="preview__text">
                  <h3 class="preview__title"><?php echo mb_substr(strip_tags($art['title']), 0, 50, 'utf-8'); ?>
                  </h3>
                  <?php
                    $art_cat = false;
                    foreach ($categories as $cat) {
                      if ($cat['id'] == $art['categorie_id']) {
                        $art_cat = $cat;
                        break;
                      }
                    }
                    ?>
                  <span class="preview__cat">Category: <?php echo $art_cat['title']; ?></span>
                  <p class="preview__par"><?php echo mb_substr(strip_tags($art['text']), 0, 180, 'utf-8'); ?>...</p>
                </div>
              </a>
              <?php
              } ?>

            </div>
          </div>

          <?php
          include "includes/sidebar.php";
          ?>

          <div class="block g  rid__item grid__item--2w">
            <h2 class="block__title">DEVELOPMENT</h2>
            <div class="block__content">
              <a href="/articles.php?category=1" class="block__all-link">All articles</a>
              <?php
              $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = 1  ORDER BY `id` DESC limit 4");
              ?>
              <?php
              while ($art = mysqli_fetch_assoc($articles)) {
              ?>
              <a href="/article.php?id=<?php echo $art['id'];  ?>" class="preview">
                <div class="preview__img-wrap">
                  <img src="<?php echo $art['image']; ?>" alt="" class="preview__img">
                </div>
                <div class="preview__text">
                  <h3 class="preview__title"><?php echo $art['title']; ?></h3>
                  <?php
                    $art_cat = false;
                    foreach ($categories as $cat) {
                      if ($cat['id'] == $art['categorie_id']) {
                        $art_cat = $cat;
                        break;
                      }
                    }
                    ?>
                  <span class="preview__cat">Category: <?php echo $art_cat['title']; ?></span>
                  <p class="preview__par"><?php echo mb_substr(strip_tags($art['text']), 0, 180, 'utf-8'); ?>...</p>
                </div>
              </a>
              <?php
              } ?>
            </div>
          </div>

          <div class="block grid__item grid__item--1w ">
            <h2 class="block__title">THE LATEST COMMENTS</h2>
            <div class="block__content" id="comments">
              <?php
              $comments  = mysqli_query($connection, "SELECT  
                                                        c.author,
                                                        c.email,
                                                        c.text,
                                                        c.id AS com_id,
                                                        a.id AS art_id,
                                                        a.title
                                                      FROM comments AS c INNER JOIN articles AS a 
                                                      ON (c.articles_id = a.id) ORDER BY c.id DESC LIMIT 5");
                
              ?>
              <?php
              while ($com = mysqli_fetch_assoc($comments)) {
              ?>
              <div class="comment">
                <div class="comment__img-wrap">
                  <img class="comment__img" src="https://www.gravatar.com/avatar/<?php echo md5($com['email']); ?>"
                    alt="">
                </div>
                <div class="comment__text">
                  <span class="comment__username"><?php echo $com['author'] ?></span>
                  <a href="/article.php?id=<?php echo $com['art_id'] ?>"
                    class="comment__article"><?php echo mb_substr(strip_tags($com['title']), 0, 30, 'utf-8'); ?>...</a>
                  <span class="comment__par">
                    <?php echo mb_substr(strip_tags($com['text']), 0, 50, 'utf-8') ?>
                  </span>
                </div>
              </div>

              <?php
              } ?>

            </div>
          </div>

          <div class="block grid__item--3w">
            <h2 class="block__title ">SUBSCRIBE TO OUR NEWSLETTER</h2>
            <div class="block__content" id="subscribeForm">
              <form class="form" action="/#subscribeForm" method="POST">
                <div class="form__block">
                  <input class="form__input" type="email" name="email" placeholder="Your email" required value="<?php if (!empty($_POST['email'])) {
                      echo $_POST['email'];
                    } ?>">
                  <input class="btn" type="submit" value="Subscribe" name="subscribe">

                </div>
                <?php 
                if(isset($_POST['subscribe'])) {
                mysqli_query($connection, "INSERT INTO `subscribers` (`email`) VALUES('" . $_POST['email'] . "')");
                echo '<div class="success" >' . 'You was subscribed successfully' . '</div>';
                exit("<meta http-equiv='refresh' content='0; url= /index.php'>");

                }
                ?>

              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php
  include "includes/footer.php"
  ?>

  <script src="js/main.min.js"></script>
  <script src="https://kit.fontawesome.com/8d4a291d01.js" crossorigin="anonymous"></script>
</body>

</html>