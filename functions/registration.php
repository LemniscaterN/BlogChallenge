<?php

require "../config/setting.php";

$name="admin";
$password="pass";

try {
    $db= new PDO(call_dsn(), call_user(),call_password());

    //SQLインジェクション対策
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    // //エラー発生で例外を投げる
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("
        INSERT INTO  users (name,password) VALUES (:name,:password)
    ");
    $stmt->bindValue(':name',$name, PDO::PARAM_STR);
    $stmt->bindValue(':password',password_hash($password,PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->execute();
    echo "ok";

}catch (PDOExcption $e) {
    // echo("エラー:".$e->getMessage());
    error($e." Writiing database was failed.");
    echo "out";
}

?>