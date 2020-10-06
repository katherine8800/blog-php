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
  <title>Just a Journal</title>
</head>

<body>

  <?php
  include "includes/header.php"
  ?>
  <main>
    <div class="container">
      <section class="section">
        <div class="grid">
          <?php

          $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = " . (int) $_GET['id']);
         

          if (mysqli_num_rows($article) <= 0) {

          ?>

          <div class="block grid__item grid__item--2w">
            <div class="block__content">
              <h1 class="article__title">
                404 Page Not Found
              </h1>
              <div class="block__content">
                <article class="article__text">
                  The article does not exist.
                </article>
              </div>
            </div>
          </div>


          <?php
          } else {
            $art = mysqli_fetch_assoc($article);
            mysqli_query($connection, "UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = " . (int) $_GET['id']);

            $category = mysqli_query($connection, "SELECT * FROM `articles_categories` WHERE `id` = " . $art['categorie_id']);
            $cat = mysqli_fetch_assoc($category);
          ?>


          <div class="block grid__item grid__item--2w">
            <div class="block__content">
              <h1 class="article__title">
                <?php echo $art['title'] ?>
              </h1>
              <span class="article__cat">Category: <?php echo $cat['title']?></span>
              <div class="article__info">
                <div class="article__options">
                  <div class="article__options-block">
                    <div class="article__options-item">
                      <i class="far fa-clock article__icon"></i>
                      <time datetime="2020/09/26"
                        class="article__options-text"><?php echo date("d.m.Y", strtotime($art['pubdate'])); ?></time>
                    </div>
                    <div class="article__options-item">
                      <i class="far fa-eye  article__icon"></i>
                      <span class="article__options-text"><?php echo $art['views'] ?></span>
                    </div>
                  </div>
                  <div class="article__options-block">
                    <form method="POST" action="/edit.php?id=<?php echo $_GET['id']?>">
                      <button type="submit" class="article__options-item article__options-item--btn" name="edit">
                        <i class="far fa-edit article__icon article__icon--btn"></i>
                      </button>
                    </form>
                    <form method="POST" action="">
                      <button type="submit" class="article__options-item article__options-item--btn" name="delete">
                        <i class="far fa-trash-alt article__icon article__icon--btn"></i>
                      </button>
                    </form>
                    <?php 
                    
                    
                    if (isset($_POST['edit'])) {
                      // print_r('edit');

                    }
                    if (isset($_POST['delete'])) {
                      mysqli_query($connection, "DELETE FROM `articles` WHERE `id` = " . (int) $_GET['id'] . "");
                      print_r('The article was deleted');
                      echo '<script>window.location = "articles.php?order=id"</script>';
                    }
                    ?>


                  </div>
                </div>
                <div class="article__img-wrap"><img class="article__img" src="<?php echo $art['image'] ?>" alt=""></div>
                <article class="article__text">
                  <?php echo $art['text'] ?>
                </article>
              </div>
            </div>

          </div>

          <?php
          }
          ?>

          <?php
          include "includes/sidebar.php";
          ?>
          <div class="grid__item grid__item--2w">
            <h2 class="block__title">Comments</h2>
            <div class="block__content">

              <?php
              $comments  = mysqli_query($connection, "SELECT * FROM `comments` WHERE `articles_id` = " . (int) $_GET['id'] . " ORDER BY `id` DESC");
              if (mysqli_num_rows($comments) <= 0) {
                echo 'No comments';
              }
              while ($com = mysqli_fetch_assoc($comments)) {
              ?>

              <div class="comment">
                <div class="comment__img-wrap">
                  <img class="comment__img" src="img/user2.jpg" alt="">
                </div>
                <div class="comment__text comment__text--article">
                  <span class="comment__username"><?php echo $com['author']; ?></span>
                  <span class="comment__date"><?php echo $com['pubdate']; ?></span>
                  <span class="comment__par comment__par--article">
                    <?php echo $com['text'] ?>
                  </span>
                </div>
              </div>
              <?php } ?>

            </div>
          </div>


          <div class="grid__item grid__item--2w" id="commentForm">
            <h2 class="block__title">Add new comment</h2>
            <div class="block__content">
              <form class="article__form" action="/article.php?id=<?php echo $_GET['id']; ?>#commentForm" method="POST">


                <input class="article__input" type="text" name="name" placeholder="Your name" value="<?php
                    if (!empty($_POST['name'])) {
                      echo $_POST['name'];
                    } ?>">
                <input class="article__input" type="email" name="email" placeholder="Your email" value="<?php
                    if (!empty($_POST['email'])) {
                      echo $_POST['email'];
                    } ?>">
                <textarea class="article__input article__input--textarea" rows="10" name="text"
                  placeholder="Type your comment here..."><?php
                    if (!empty($_POST['text'])) {
                      echo $_POST['text'];
                    } ?></textarea>
                <input type="submit" class="btn" id="formSubmit" name="do_post" value="Add comment">
                <?php
                if (isset($_POST['do_post'])) {
                  $errors = array();

                  if ($_POST['name'] == '') {
                    $errors[] = 'Type your name';
                  }

                  if ($_POST['email'] == '') {
                    $errors[] = 'Type your email';
                  }

                  if ($_POST['text'] == '') {
                    $errors[] = 'Type your comment ';
                  }

                  if (empty($errors)) {


                    mysqli_query($connection, "INSERT INTO `comments` (`author`, `email`, `text`, `pubdate`, `articles_id`) VALUES('" . $_POST['name'] . "', '" . $_POST['email'] . "', '" . $_POST['text'] . "', NOW(), '" . $_GET['id'] . "' )");

                    echo '<span class="success">' . 'Your comment was added successfully' . '</span>';
                    
                $loc = 'article.php?id=' . $_GET['id'] . '#commentForm';
                exit("<meta http-equiv='refresh' content='0; url= ' . $loc . '>");
                   
                  } else {
                    echo '<span class="error">' . $errors['0'] . '</span>';
                  }
                }

                 ?>

              </form>
            </div>
          </div>
      </section>
    </div>
  </main>

  <?php
  include "includes/footer.php"
  ?>
  <script src="js/main.min.js"></script>
  <script src="https://kit.fontawesome.com/8d4a291d01.js" crossorigin="anonymous"></script>
</body>

</html>