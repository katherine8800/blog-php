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
            <h2 class="block__title">Create an article</h2>
            <div class="block__content">
              <form class="create__form" method="POST" action="/create.php">
                <?php 
              $categories = mysqli_query($connection, "SELECT * FROM `articles_categories`");
              ?>
                <div class="create__input-block">
                  <label class="create__label" for="title">Article Title</label>
                  <input class="create__input" type="text" name="title" required>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="img">Image link</label>
                  <input class="create__input" type="text" name="img" required>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="text">Article Text</label>
                  <textarea rows="20" class="create__input" name="text" required></textarea>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="category">Select the article category</label>
                  <select name="category" class="create__input">
                    <?php 
                  while($cat = mysqli_fetch_assoc($categories)) {

                  
                  ?>
                    <option value="<?php echo $cat['id'] ?>"><?php echo $cat['title'] ?></option>

                    <?php 
                    }
                    ?>
                  </select>
                </div>
                <div class="create__input-block">
                  <label class="create__label" for="date">Publication date</label>
                  <input class="create__input" type="datetime-local" name="date"
                    value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                </div>
                <div class="create__input-block">
                  <input type="submit" class="btn" value="Create" name="create">
                </div>
                <?php 
                if (isset($_POST['create'])) {
                  
            mysqli_query($connection, "INSERT INTO `articles`(`title`, `image`, `text`, `categorie_id`, `pubdate`) VALUES ('" . $_POST['title'] . "', '" . $_POST['img'] . "', '" . $_POST['text'] . "', '" . $_POST['category'] . "', '" . $_POST['date'] . "')");

            echo '<script>window.location = "articles.php?order=id"</script>';
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