<?php
if (!isset($_SESSION)) {
  session_start();
}
session_regenerate_id(true);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <a class="navbar-brand " href="../hp/index.php"><u>IGC</u></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav mr-auto">
      <a class="nav-link text-dark" href="../hp/index.php">ホーム <span class="sr-only">(current)</span></a>
      <a class="nav-link text-dark" href="../hp/member.php">メンバー紹介</a>
      <a class="nav-link text-dark" href="../hp/rank.php">順位</a>
      <a class="nav-link text-dark" href="../hp/blog.php">ブログ</a>
    </div>
    <div class="navbar-nav">
      <a class="nav-link text-dark" href="https://www.instagram.com/igc.golf/" target="_blank" rel="noopener noreferrer"><img src="./img/insta.jpg" alt="インスタグラム" width="20" height="20"></a>
      <?php if(isset($_SESSION['login']) == false) { ?>
      <a class="nav-link text-dark" href="../hp/sign_up.php"><img src="./img/kao.png" alt="顔" width="10" height="10">新規登録</a>
      <a class="nav-link text-dark" href="../hp/login.php"><img src="./img/kao.png" alt="顔" width="10" height="10">Log In</a>
      <?php } else { ?>
        <a class="nav-link text-dark" href="../hp/logout.php"><img src="./img/kao.png" alt="顔" width="10" height="10">ログアウト</a>
      <?php } ?>
    </div>
  </div>
</nav>