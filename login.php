<?php 
  session_start();
  session_regenerate_id(true);
  if(isset($_SESSION['login'])==true) {
    header('Location:index.php');
    exit();
  }
?>
<!doctype html>
<html lang="ja">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>ログイン</title>
</head>
<body>
  <?php include (dirname(__FILE__) . '/common/head.php' ); ?>
  <main>
    <div class="container mt-5 pt-5 w-50">
      <h3>ログイン</h3>
      <form method="POST" action="login_check.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="member_id">ID：</label>
          <input class="form-control content_box" type="text" name="member_id" id="member_id" pattern="^[0-9A-Za-z]+$" required>
        </div>
        <div class="form-group">
          <label for="ps">パスワード：</label>
          <input class="form-control content_box" type="text" name="ps" id="ps" pattern="^[0-9A-Za-z]+$" required>
        </div>
        <input class="btn btn-primary" type="submit" value="送信">
      </form>
    </div>
  </main>
  <?php include (dirname(__FILE__) . '/common/foot.html' ); ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>