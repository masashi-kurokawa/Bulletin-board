<?php
session_start();
$_POST = $_SESSION;

require_once("../config/config.php");
require_once("../model/User.php");

try {
  $user = new User($host, $dbname, $user, $pass); //MySQLのデータベースに接続
  $user->connectDb();
  //登録処理
  if($_POST) {
    $user->add($_POST);
  }
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
<link rel="stylesheet" type="text/css" href="../css/signup.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

</script>
</head>
<body>
  <header>
    <h1>登録が完了致しました。</h1>
  </header>
  <div id="login">
    <a href="index.php">ログインページへ戻る</a>
  </div>
</body>
</html>
