<?php
require "../config/setting.php";
require "../functions/write_db.php";
require "../functions/delete_db.php";
require "../login/loginCheck.php";

function loca(){
    header('Location:../index.php'); 
}



my_session_start();
if(!isset($_SESSION['id']))loca();
if(!isset($_SESSION['token']))loca();
if(filter_input(INPUT_POST,'token') != $_SESSION['token']) loca();

$articleId = filter_input(INPUT_POST,'articleId');
$title = filter_input(INPUT_POST,'title');
$tag = filter_input(INPUT_POST,'tag');
$content = filter_input(INPUT_POST,'content');
$key = filter_input(INPUT_POST,'key');
unset($_SESSION['token']);

if($key==="delete"){
    delete_db($articleId);
}
else{
    if($articleId=="-1")$articleId=write_db($title,$content,$tag);
    else edit_db($articleId,$title,$content,$tag);
}

// header('Location:../index.php?articleId='.$articleId); 
?>