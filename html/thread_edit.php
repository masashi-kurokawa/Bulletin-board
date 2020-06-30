<!-- 作成スレッド一覧ページ -->
<?php
session_start();
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
  //削除処理
    if(isset($_GET['del'])) {
        $user->delete($_GET['del']);
      }
  //参照処理
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
  <p class="logout"><a href="thread.php">スレッド一覧ページに戻る</a></p>
  <header>
    <h1>作成スレッド一覧</h1>
  </header>
  <div id="">
    <table border="3" width="800">
      <tr>
        <th width="50%">スレッド名</th>
        <th width="25%">編集</th>
        <th width="25%">削除</th>
      </tr>
        <?php foreach($result as $row): ?>
          <?php if ($_SESSION['user']['id'] == $row['user_id']): ?>
          <tr>
            <th width="50%"><?=$row['thread_name']?></th>
            <th width="25%"><a href="thread_edit_only.php?edit=<?=$row['id']?>">編集</a></th>
            <th width="25%"><a href="?del=<?=$row['id']?>" onclick="if(!confirm('ID:<?=$row['id']?><削除しますが大丈夫ですか？')) return false;">削除</a></th>
          </th>
        <?php endif; ?>
        <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
