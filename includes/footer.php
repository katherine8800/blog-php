<?php
// require  "includes/config.php";
?>
<footer>
  <div class="container">
    <div class="footer">
      <div class="footer__logo">
        <a href="/ " class="logo"><?php echo $config['title']; ?></a>

      </div>

      <ul class="footer__menu">

        <li class="footer__menu-item"><a href="/articles.php" class="footer__menu-link">news</a></li>
        <li class="footer__menu-item"><a href="/create.php" class="footer__menu-link">create</a></li>

      </ul>
      <div class="menu__socials">
        <div class="menu__socials-wrap">
          <a href="<?php echo $config['facebook_url'] ?>" target="_blank" class="menu__social">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="<?php echo $config['instagram_url'] ?>" target="_blank" class="menu__social">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="<?php echo $config['youtube_url'] ?>" target="_blank" class="menu__social">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
        <span class="footer__copyright">Copyright © Katherine Zhdanova</span>
      </div>


    </div>

  </div>
</footer>