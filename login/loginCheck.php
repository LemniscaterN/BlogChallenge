<?php

function my_session_start() {
    session_start();
    // 古過ぎるセッションIDを使うことを許してはいけない
    if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 3000) {
        session_destroy();
        ini_set('session.use_strict_mode', 0);
        session_start();
    }
}

function login(){
    if(isset($_SESSION['id'])){
        return true;
    }else if(isset($_POST['name'])&& isset($_POST['password'])){
        //ログインしてない状態でユーザ名とパスワード送信　
        // echo $_POST['name'].":".$_POST['password'];
        try{
            $db= new PDO(call_dsn(), call_user(),call_password());
            //SQLインジェクション対策
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            // //エラー発生で例外を投げる
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare("
                SELECT * FROM users WHERE name=:name
            ");
            $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            //クエリ実行
            $stmt->execute();
            $row=$stmt->fetch();

            // echo "login:".var_dump($row)."<br>";

            if($row){
                if(password_verify($_POST['password'],$row["password"])){
                    
                    //セッションIDの再作成 セッションハイジャック対策
                    
                    session_regenerate_id(true);
                    

                    $_SESSION['id']=$row['id'];
                    $_SESSION['deleted_time'] = time();

                    // echo "成功";
                    

                    return true;
                }
            }else{
                //レコードを取得できなかったとき
                //入力に誤りがある
                //もう一度フォームを表示
                // echo "失敗";
                header('Location:index.php'); 
            }
        }catch(PDOExcption $e){
            die('エラー:'.$e->getMessage());
        }

    }
    // echo "失敗";
    return false;
}

?>