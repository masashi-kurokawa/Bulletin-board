<?php
require_once("DB.php");

class Messes extends DB {
  //ユーザーの参照　select
    public function findByuser($userid){
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$userid);
    $stmt->execute($params);
    $users = $stmt->fetch();
    return $users;
  }
  //スレッドの参照　select
    public function findById($id){
    $sql = 'SELECT * FROM thread WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    // 挿入する値を配列に格納する
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  //スレッドメッセージ参照　select
    public function findAll() {
      $sql = 'SELECT * FROM message';
      $stmt = $this->connect->prepare($sql);
      $stmt->execute();
      $mess = $stmt->fetchAll();
      return $mess;
    }
  // 登録　insert
  public function add($arr){
      $sql = "INSERT INTO message(thread_id, created, message, user_id, user_name) VALUES(:thread_id, :created, :message, :user_id, :user_name)";
      $stmt = $this->connect->prepare($sql);
      $params = array(
        ':thread_id'=>$arr['thread_id'],
        ':created'=>date('Y/m/d H:i:s'),
        ':message'=>$arr['message'],
        ':user_id'=>$arr['user_id'],
        ':user_name'=>$arr['user_name'],
      );
      $stmt->execute($params);
    }
    //削除　delete
  public function delete($id = null) {
    if(isset($id)) {
      $sql = "DELETE
      FROM message WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id'=>$id);
      $stmt->execute($params);
    }
  }
  // //入力チェック validate
  public function validate($arr) {
    if (empty($arr['message'])) {
      $message['message'] = '内容を入力してください。';
    }
    return $message;
  }
}
