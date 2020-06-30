<?php
require_once("DB.php");

class Thread extends DB {
//参照　select
  public function findAll() {
    $sql = 'SELECT * FROM thread';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }
//参照（条件つき）select
  public function findById($id){
    $sql = 'SELECT * FROM thread WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  // 登録　insert
  public function add($arr){
    try{
      $sql = "INSERT INTO thread (thread_name, user_id) VALUES (:thread_name, :user_id)";
      $stmt = $this->connect->prepare($sql);
      $params = array(
        ':thread_name'=>$arr['thread_name'],
        ':user_id'=>$arr['user_id'],
      );
      $stmt->execute($params);
    }
    //エラーの描きだしをするやつ
    catch (PDOException $e) {
      echo "ErrorMes : " . $e->getMessage() . "\n";
      echo "ErrorCode : " . $e->getCode() . "\n";
      echo "ErrorFile : " . $e->getFile() . "\n";
      echo "ErrorLine : " . $e->getLine() . "\n";
    }
  }
  //削除　delete
  public function delete($id = null) {
    if(isset($id)) {
      $sql = "DELETE FROM thread WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id'=>$id);
      $stmt->execute($params);
    }
  }
  //編集　update
public function edit($arr) {
  $sql = "UPDATE thread SET thread_name = :thread_name, user_id = :user_id WHERE id = :id";
  $stmt = $this->connect->prepare($sql);
  $params = array(
    ':id'=>$arr['id'],
    ':thread_name'=>$arr['thread_name'],
    ':user_id'=>$arr['user_id'],
  );
  $stmt->execute($params);
}
  // //入力チェック validate
  public function validate($arr) {
    $thread_name = $arr['thread_name'];
    $sql = ('SELECT * FROM thread WHERE thread_name = :thread_name limit 1');
    $stmt = $this->connect->prepare($sql);
    $params = array(':thread_name'=>$thread_name);
    $stmt->execute($params);
    $result = $stmt->fetch();
    //スレッド名
    if (empty($arr['thread_name'])) {
      $message['thread_name'] = 'スレッド名を入力してください。';
    }
    elseif ($result > 0) {
      $message['thread_name'] = '同じスレッドがあります。';
    }
    else {
      if(mb_strlen($arr["thread_name"]) > 15) {
        $message['thread_name'] = '１５文字以内に収めてください。';
      }
    }
    return $message;
  }
}
?>
