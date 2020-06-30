<!-- スレッド名編集ページ -->
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
  //編集処理したいスレッドの名前検索とセット
    if(isset($_GET['edit'])) {
        $result[0] = $user->findById($_GET['edit']);
      }
  //編集処理
    if($_POST) {
      $message = $user->validate($_POST);
        if(empty($message['thread_name'])) {
          $user->edit($_POST);
          header('Location: /self_made/html/thread_edit.php');
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
    <h1>スレッド名変更画面</h1>
  </header>
  <?php if(isset($message['thread_name'])) echo"<P class='error'>" .$message['thread_name']."</P>" ?>
  <div id="login">
    <form action="" method="post">
      <dl>
        <dt><label for="userid">スレッド名</label></dt>
        <dd><input type="text" name="thread_name" value="<?php if(isset($result[0])) echo $result[0] ['thread_name'] ?>" size="80"></dd>
      </dl>
      <input type="hidden" name="id" value="<?php echo $result[0] ['id']; ?>">
      <input type="hidden" name="user_id" value="<?php echo $result[0] ['user_id']; ?>">
      <input class="button" type="submit" name="" value="変更"
    onclick="if(!confirm('編集しますよろしいですか？')) return false;">
    </form>
  </div>
</body>
</html>
