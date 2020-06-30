<!-- スレッド登録ページ -->
<?php
session_start();
$user_id = $_SESSION['user']['id'];
require_once("../config/config.php");
require_once("../model/Thread.php");

if (!isset($_SESSION['user'])) {
  header('Location: /self_made/html/index.php');
  exit;
}

try {
  $user = new Thread($host, $dbname, $user, $pass); //MySQLのデータベースに接続
  $user->connectDb();

  if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header('Location: /self_made/html/index.php');
  }
    //登録処理
    if($_POST) {
      $message = $user->validate($_POST);
        if(empty($message['thread_name'])) {
            $user->add($_POST);
            header('Location: /self_made/html/thread.php');
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
<link rel="stylesheet" type="text/css" href="../css/thread.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

</script>
</head>
<body>
  <p class="logout"><a href="?logout=1" onclick="if(!confirm('ログアウトしてよろしいですか？')) return false;">ログアウト</a></p>
  <p class="logout"><a href="thread.php">スレッド一覧ページに戻る</a></p>
  <header>
    <h1>スレッド作成ページ</h1>
  </header>
  <div id="login">
    <?php if(isset($message['thread_name'])) echo"<P class='error'>" .$message['thread_name']."</P>" ?>
    <form action="" method="post">
      <dl>
        <dt><label for="userid">スレッド名</label></dt>
        <dd><input type="text" name="thread_name" value="" size="80"></dd>
      </dl>
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
      <input class="button" type="submit" name="submit" value="作成"
      onclick="if(!confirm('作成してよろしいですか？')) return false;">
    </form>
  </div>
</body>
</html>
