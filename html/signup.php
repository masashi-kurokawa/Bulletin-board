<?php
session_start();
$_SESSION = $_POST;

require_once("../config/config.php");
require_once("../model/User.php");

try {
  $user = new User($host, $dbname, $user, $pass); //MySQLのデータベースに接続
  $user->connectDb();
  //バリデート
  if($_POST) {
    $message = $user->validate($_POST);
    if(isset($message['user_name']) || isset($message['password']) || isset($message['email']) || isset($message['name'])) {
    } else {
      header('Location: /self_made/html/confirm.php');
      exit;
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
<link rel="stylesheet" type="text/css" href="../css/signup.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

</script>
</head>
<body>
  <header>
    <h1>新規登録</h1>
  </header>
    <?php if(isset($message['user_name'])) echo"<P class='error'>" .$message['user_name']."</P>" ?>
    <?php if(isset($message['password'])) echo"<P class='error'>" .$message['password']."</P>" ?>
    <?php if(isset($message['email'])) echo"<P class='error'>" .$message['email']."</P>" ?>
    <?php if(isset($message['name'])) echo"<P class='error'>" .$message['name']."</P>" ?>
  <div id="login">
    <form action="" method="post">
      <div class="textright">
        <label for="name">ユーザー名:</label>
        <input type="text" class="user_name" name="user_name" size="50" value="<?php if(isset($result['User'])) echo $result['User'] ['user_name'] ?>">
      </div>
      <div class="textright">
        <label for="">パスワード:</label>
        <input type="password" class="password" name="password" size="50" value="<?php if(isset($result['User'])) echo $result['User'] ['password'] ?>">
      </div>
      <div class="textright">
        <label for="">メールアドレス:</label>
        <input type="email" class="email" name="email" size="50" value="<?php if(isset($result['User'])) echo $result['User'] ['email'] ?>">
      </div>
      <div class="textright">
        <label for="">名前(フルネーム):</label>
        <input type="name" class="name" name="name" size="50" value="<?php if(isset($result['User'])) echo $result['User'] ['name'] ?>">
      </div>
      <input type="hidden" name="" value="abc123">
      <input class="button" type="submit" value="登録"　id="submit_btn">
    </form>
  </div>
</body>
</html>
