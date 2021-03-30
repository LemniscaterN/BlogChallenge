<?php

// require_once __DIR__ . '/functions.php';
// require_logined_session();

// CSRFトークンを検証
// if (!validate_token(filter_input(INPUT_GET, 'token'))) {
//     // 「400 Bad Request」
//     header('Content-Type: text/plain; charset=UTF-8', true, 400);
//     exit('トークンが無効です');
// }

// セッション用Cookieの破棄

// // セッションファイルの破棄


// // ログアウト完了後に /login.php に遷移

require "loginCheck.php";
my_session_start();

setcookie(session_name(), '', 1);
unset($_SESSION['id']);
session_destroy();


$hostname = $_SERVER['HTTP_HOST'];//ドメインを取得
echo "host".$hostname;
if (!empty($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'],$hostname) !== false)) {
    header('Location:'. $_SERVER['HTTP_REFERER']);
}else header("Location:../index.php");

?>