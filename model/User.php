<?php
require_once("DB.php");

class User extends DB {
  //ログイン用
  public function login($arr) {
    $sql = 'SELECT * FROM users WHERE email = :email AND password = :password';
    $stmt = $this->connect->prepare($sql);
    $params = array(':email'=>$arr['email'], ':password'=>$arr['password']);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  //参照　select
  public function findAll() {
    $sql = 'SELECT * FROM users';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }
  //参照（条件つき）select
  public function findById($id){
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  //登録　insert
  public function add($arr){
    try{
      $sql = "INSERT INTO users (user_name, password, email, name, role) VALUES (:user_name, :password, :email, :name, :role)";
      $stmt = $this->connect->prepare($sql);
      $params = array(
        ':user_name'=>$arr['user_name'],
        ':password'=>$arr['password'],
        ':email'=>$arr['email'],
        ':name'=>$arr['name'],
        ':role'=>0
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
      $sql = "DELETE
      FROM users WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id'=>$id);
      $stmt->execute($params);
    }
  }
  //入力チェック validate
  public function validate($arr) {
    $email = $arr['email'];
    $user_name = $arr['user_name'];
    $telLength = strlen($user_name);
    $sql = 'SELECT * FROM users WHERE email = :email limit 1';
    $stmt = $this->connect->prepare($sql);
    $params = array(':email'=>$email);
    $stmt->execute($params);
    $result = $stmt->fetch();
    //ユーザー名
    if (empty($arr['user_name'])) {
      $message['user_name'] = 'ユーザー名を入力してください。';
    }
    elseif ($telLength > 10) {
      $message['user_name'] = '10文字以内に収めてください。';
    }
    //パスワード
    if (empty($arr['password'])) {
      $message['password'] = 'パスワードを入力してください。';
    }
    //メールアドレス
    if (empty($arr['email'])) {
      $message['email'] = 'メールアドレスを入力してください。';
    }
    elseif ($result > 0) {
      $message['email'] = '同じメールアドレスがあります。';
    }
    else {
      if(!filter_var($arr['email'], FILTER_VALIDATE_EMAIL)) {
        $message['email'] = 'メールアドレスが正しくありません。';
      }
    }
    //名前（フルネーム）
    if (empty($arr['name'])) {
      $message['name'] = '名前（フルネーム）を入力してください。';
    }
    return $message;
  }
}
?>
