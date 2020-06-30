<!-- スレッド一覧 -->
<?php
session_start();
$user_id = $_SESSION['user']['id'];
if (isset($_GET['id'])) {
  $_SESSION['thread']['id'] = $_GET['id'];
}

require_once("../config/config.php");
require_once("../model/Messes.php");
require_once("../model/Thread.php");
require_once("../model/User.php");

if (!isset($_SESSION['user'])) {
  header('Location: /self_made/html/index.php');
  exit;
}

try {
  $user = new Messes($host, $dbname, $user, $pass); //MySQLのデータベースに接続
  $user->connectDb();

  if (isset($_GET['logout'])) {
    //セッションに入っているユーザー情報を破棄する
    $_SESSION = array();
    session_destroy();
    header('Location: /self_made/html/index.php');
  }
  //スレッドの参照
  if(isset($_SESSION['thread']['id'])) {
    $result[0] = $user->findById($_SESSION['thread']['id']);
  }
  //メッセージ参照
  $mess = $user->findAll();
  //ユーザ参照
  $users = $user->findByuser($user_id);
  //削除処理
  if(isset($_GET['del'])) {
    $user->delete($_GET['del']);
    header('Location: /self_made/html/messes.php');
  }
  //登録処理
  if($_POST) {
    $message = $user->validate($_POST);
    if(empty($message['message'])) {
    // var_dump($_POST['message']);
    $user->add($_POST);
    header('Location: /self_made/html/messes.php');
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
<link rel="stylesheet" type="text/css" href="../css/messes.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

</script>
</head>
<body>
  <p class="logout"><a href="?logout=1" onclick="if(!confirm('ログアウトしてよろしいですか？')) return false;">ログアウト</a></p>
  <p class="logout"><a href="thread.php">スレッド一覧ページに戻る</a></p>
  <header>
    <h1><?php if(isset($result[0])) echo $result[0] ['thread_name'] ?></h1>
  </header>
  <div id="">
    <form method="post">
      <?php if(isset($message['message'])) echo"<P class='error'>" .$message['message']."</P>" ?>
	<div class="mess">
		<label for="message">メッセージ</label>
		<textarea id="message" name="message"></textarea>
	</div>
  <input type="hidden" name="thread_id" value="<?php echo $_SESSION['thread']['id']; ?>">
  <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
  <input type="hidden" name="user_name" value="<?php echo $users['user_name']; ?>">
	<input type="submit" name="btn_submit" value="書き込む" onclick="if(!confirm('入力した内容で書き込んでもよろしいですか？')) return false;">
</form>
  </div>
<section>
  <?php foreach($mess as $row): ?>
    <?php if ($row['thread_id'] == $_SESSION['thread']['id']): ?>
  <article class="">
    <div class="info">
      <h3><?=$row['user_name']?></h3>
      <h3><?=$row['created']?></h3>
        <?php if ($_SESSION['user']['id'] == $row['user_id']): ?>
          <h3><a href="?del=<?=$row['id']?>" onclick="if(!confirm('ID:<?=$row['id']?><削除しますが大丈夫ですか？')) return false;">削除</a></h3>
        <?php endif; ?>
    </div>
    <p><?=$row['message']?></p>
  </article>
  <?php endif; ?>
  <?php endforeach; ?>
</section>
</body>
</html>
