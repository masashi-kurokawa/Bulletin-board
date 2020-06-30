<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
  // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass); //MySQLのデータベースに接続
  $user->connectDb();

  if($_POST) {
    $result = $user->login($_POST);
    if(!empty($result)) {
      $_SESSION['user'] = $result;
      header('Location: /self_made/html/thread.php');
      exit;
    }
    else{
      $message = "ログインできませんでした。新規登録がまだの場合は登録をお願い致します。";
      $_SESSION = array();
      session_destroy();
    }
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
<link rel="stylesheet" type="text/css" href="../css/loginbase.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

</script>
</head>
<body>
  <header>
    <h1>好きな○○掲示板<br>ログインページ</h1>
  </header>
  <?php if(isset($message)) echo"<P class='error'>" .$message."</P>" ?>
  <div id="login">
    <form action="" method="post">
      <dl>
        <dt><label for="email">メールアドレス</label></dt>
        <dd><input type="text" name="email" value="" size="50"></dd>
      </dl>
      <dl>
        <dt><label for="password">パスワード</label></dt>
        <dd><input type="password" name="password" id="password" value="" size="50"></dd>
      </dl>
      <input class="button" type="button" value="新規登録" onclick="location.href='signup.php'">
      <input class="button" type="submit" name="submit" value="ログイン">
    </form>
  </div>
</body>
</html>
