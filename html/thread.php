<!-- スレッド一覧 -->
<?php
session_start();
require_once("../config/config.php");
require_once("../model/Thread.php");

if (!isset($_SESSION['user'])) {
  header('Location: /self_made/html/index.php');
  exit;
}
try {
  // MySQLへの接続
  $user = new Thread($host, $dbname, $user, $pass); //MySQLのデータベースに接続
  $user->connectDb();
  if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header('Location: /self_made/html/index.php');
  }

  $result = $user->findAll();
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
  <header>
    <h1>好きな○○<br>スレッド一覧</h1>
  </header>
  <div id="">
    <table border="3" width="500">
      <tr>
        <th><a href="thread_edit.php">編集・削除</a></th>
        <th><a href="thread_create.php">スレッド追加</a></th>
      </tr>
    </table>
  </div>
  <div id="thread">
    <table width="900">
      <?php $n=0; ?>
      <tr>
        <?php foreach($result as $row): ?>
          <?php if ($n %3 != 0){ ?>
            <th><a href="messes.php?id=<?=$row['id']?>"><?=$row['thread_name']?></a></th>
          <?php }else{ ?>
            </tr>
            <th><a href="messes.php?id=<?=$row['id']?>"><?=$row['thread_name']?></a></th>
          <?php }?>
        <?php $n++;endforeach; ?>
      </tr>
    </table>
  </div>
</body>
</html>
