<?php
function delete_db($id){
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("
            DELETE from articles WHERE id=:id
        ");
        $stmt->bindValue(':id',$id, PDO::PARAM_STR);
        $stmt->execute();

        $stmt2 = $db->prepare("
        DELETE from tag_map WHERE articleId=:id
        ");
        $stmt2->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt2->execute();


        $db->query("
            DELETE tag FROM  tag LEFT OUTER JOIN 
                (SELECT DISTINCT tagId FROM tag_map)as subq1
            ON  tagId = tag.id WHERE  tagId IS NULL
        ");

        return true;

    }catch (PDOExcption $e) {
        error($e." Writiing database was failed.");
        return false;
    }
}
?>