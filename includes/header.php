<?php
// require  "includes/config.php";
?>
<header>
  <div class="header">
    <div class="container">
      <nav class="header__nav">
        <a href="/" class="logo"><?php echo $config['title']; ?></a>
        <button class="hamburger hamburger--spin" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
        <div class="header__menu ">
          <ul class="menu top" id="menu">
            <li class="menu__item"><a href="/articles.php?order=id" class=" menu__link">
                news
              </a></li>

            <li class="menu__item"><a href="create.php" class="menu__link">
                create
              </a></li>


          </ul>
        </div>
      </nav>
    </div>
  </div>

  <?php
  $categories_q = mysqli_query($connection, "SELECT * FROM `articles_categories`");
  $categories = array();
  while ($cat = mysqli_fetch_assoc($categories_q)) {
    $categories[] = $cat;
  }
  ?>
  <div class="categories" id="categoriesTitle">
    <div class="container">
      <button class="categories__title">categories</button>
      <ul class="categories__list dnone" id="categories">
        <?php
        foreach ($categories as $cat) {

        ?>
        <li class="categories__item">
          <a href="/articles.php?category=<?php echo $cat['id']; ?>"
            class="categories__link"><?php echo $cat['title']; ?></a>
        </li>

        <?php } ?>
      </ul>
    </div>
  </div>
</header>