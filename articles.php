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


          <div class="block grid__item grid__item--2w w3 m-right">
            <h2 class="block__title">
              <?php
              $per_page = 4; 
              $page = 1;
              $category = 0;
              $order = '';

              if(isset($_GET['page'])) {
                $page = (int) $_GET['page'];
              }

              if(isset($_GET['category'])) {
                $category = (int) $_GET['category'];
              }

              if(isset($_GET['order'])) {
                $order = $_GET['order'];
               
              }
                // Counting the number of articles
              if(!empty($_GET['category'])) {
                $total_count_q = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles` WHERE `categorie_id` = " . (int) $_GET['category'] . "");
              } else {
                $total_count_q = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles`");
              }
              $total_count = mysqli_fetch_assoc($total_count_q)['total_count'];
              $total_pages = ceil($total_count / $per_page);

              if($page <= 1 || $page > $total_pages) {
                $page = 1;
              }

              $offset = ($per_page * $page) - $per_page ;

                // Showing the articles
              if(!empty($_GET['category'])) {
                $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = " . (int) $_GET['category'] . " ORDER BY `views` DESC LIMIT $offset, $per_page ");


              } else if(!empty($_GET['order'])){
                $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT $offset, $per_page ");

              } else {
                $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `views` DESC LIMIT $offset, $per_page ");
              }
              

              $articles_exist = false;

              if(mysqli_num_rows($articles) <= 0) {
                echo 'No articles';
              } else {
              $articles_exist = true;

              }
              
          
                if(isset($_GET['category'])) {
                    $page_cat = false;
                    foreach ($categories as $cat) {
                      if ($cat['id'] == $_GET['category']) {
                        echo $cat['title'];
                        break;
                      } 
                    }
                  
                } else {
                  echo 'All articles';
                }
            ?>
            </h2>
            <div class="block__content">

              <?php
              echo '<span class="found-text">' . $total_count . ' articles was found</span>';
              while ($art = mysqli_fetch_assoc($articles)) {
              ?>
              <a href="/article.php?id=<?php echo $art['id']; ?>" class="preview">
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
                  <div class="article__options-block">
                    <div class="article__options-item">
                      <span class="preview__cat">Category: <?php echo $art_cat['title']; ?></span>

                    </div>
                    <div class="article__options-item">
                      <i class="far fa-eye  article__icon"></i>
                      <span class="article__options-text"><?php echo $art['views'] ?></span>
                    </div>
                  </div>

                  <p class="preview__par"><?php echo mb_substr(strip_tags($art['text']), 0, 180, 'utf-8'); ?>...</p>
                </div>
              </a>
              <?php
              } 
              
              if($articles_exist) {
                echo '<div class="paginator">';
                if($page > 1) {
                  echo '<a class="paginator__link" href="/articles.php?order=' . ($order) . '&category=' . ($category) . '&page='. ($page - 1) .'"><i class="fas fa-chevron-left paginator__item"></i></a>';
                }
                if($page < $total_pages) {
                  echo '<a class="paginator__link"  href="/articles.php?order=' . ($order) . '&category=' . ($category) . '&page='. ($page + 1) .'"><i class="fas fa-chevron-right paginator__item"></i></a>';
                }
                echo '</div>';
              }
              ?>

            </div>
          </div>
          <?php
          include "includes/sidebar.php";
          ?>



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