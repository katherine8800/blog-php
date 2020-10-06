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
          <div class="block grid__item grid__item--3w m-right">
            <h2 class="block__title">Edit The article</h2>
            <div class="block__content">
              <form class="create__form" method="POST" action="">
                <?php 
              $categories = mysqli_query($connection, "SELECT * FROM `articles_categories`");

              $article =  mysqli_query($connection, "SELECT * FROM `articles` WHERE `id`  = " . (int) $_GET['id']);
              $art = mysqli_fetch_assoc($article);
              ?>
                <div class="create__input-block">
                  <label class="create__label" for="title">Article Title</label>
                  <input class="create__input" type="text" name="title" value="<?php echo $art['title'] ?>" required>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="img">Image link</label>
                  <input class="create__input" type="text" name="img" value="<?php echo $art['image'] ?>" required>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="text">Article Text</label>
                  <textarea rows="20" class="create__input" name="text" required><?php echo $art['text'] ?></textarea>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="category">Select the article category</label>
                  <select name="category" class="create__input">
                    <?php 
                  while($cat = mysqli_fetch_assoc($categories)) {

                  
                  ?>
                    <option value="<?php echo $cat['id'] ?>" <?php if($cat['id'] == $art['categorie_id']) {
                      echo 'selected';
                    } ?>><?php echo $cat['title'] ?></option>

                    <?php 
                    }
                    ?>
                  </select>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="date">Publication date</label>
                  <input class="create__input" type="datetime-local" name="date"
                    value="<?php echo date("Y-m-d\TH:i", strtotime($art['pubdate'])); ?>" required>
                </div>
                <div class="create__input-block">
                  <input type="submit" class="btn" value="Edit" name="edit_article">
                </div>
                <?php 
                
                if (isset($_POST['edit_article'])) {
                  
                  mysqli_query($connection, "UPDATE `articles` SET 
                  `title` = '" . $_POST['title'] . "', 
                  `image` = '" . $_POST['img'] . "', 
                  `text` = '" . $_POST['text'] . "', 
                  `categorie_id` = '" . $_POST['category'] . "', 
                  `pubdate` = '" . $_POST['date'] . "' WHERE `id` = " . (int) $_GET['id']);

                  echo '<script>window.location = "article.php?id=' . $_GET['id'] . '" </script>';

                  // $art_loc = 'article.php?id=' . $_GET['id'];
                  // exit("<meta http-equiv='refresh' content='0; url= ' . $art_loc . '>");
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