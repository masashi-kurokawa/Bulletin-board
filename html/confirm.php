<?php
session_start();
$_POST = $_SESSION;

require_once("../config/config.php");
require_once("../model/User.php");

try {
  $user = new User($host, $dbname, $user, $pass); //MySQLのデータベースに接続
  $user->connectDb();
}
catch (PDOException $e) { // PDOExceptionをキャッチする
  print "エラー!: " . $e->getMessage(). "<br/gt;";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>DBサンプル</title>
<link rel="stylesheet" type="text/css" href="../css/base.css">
<link rel="stylesheet" type="text/css" href="../css/confirm.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

</script>
</head>
<body>
  <header>
    <h1>登録内容確認ページ</h1>
  </header>
  <div id="login">
    <form action="conplete.php" method="post">
      <div class="textright">
        <label for="">ユーザー名:<?php echo $_POST["user_name"]; ?></label>
      </div>
      <div class="textright">
        <label for="">パスワード:<?php echo $_POST["password"]; ?></label>
      </div>
      <div class="textright">
        <label for="">メールアドレス:<?php echo $_POST["email"]; ?></label>
      </div>
      <div class="textright">
        <label for="">名前:<?php echo $_POST["name"]; ?></label>
      </div>
      <input class="button" type="submit" name="submit" value="登録">
    </form>
  </div>
</body>
</html>
