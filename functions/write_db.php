<?php
function edit_db($id,$title,$content,$tags){
    $tags= explode(",", $tags);
    $tags = array_unique($tags);
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("
            UPDATE articles SET title=:title , content=:content WHERE id=:id
        ");
        $stmt->bindValue(':title',$title, PDO::PARAM_STR);
        $stmt->bindValue(':content',$content, PDO::PARAM_STR);
        $stmt->bindValue(':id',$id, PDO::PARAM_STR);
        $stmt->execute();

        //一旦全削除
        $stmt2 = $db->prepare("
            DELETE FROM tag_map WHERE articleId = :id
        ");
        $stmt2->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt2->execute();

        //タグがtagテーブルに存在するか        
        foreach($tags as $tag){
            if(trim($tag)=="")continue;
            $isExistsTag = $db->prepare("
                SELECT id FROM tag WHERE  name = :tag
            ");
            $isExistsTag->bindValue(':tag',$tag, PDO::PARAM_STR); 
            $isExistsTag->execute();
            $result=$isExistsTag->fetch();
            
            if($result==false){
                $tagInsert = $db->prepare("
                    INSERT INTO tag (name) VALUES (:tag)
                ");
                $tagInsert->bindValue(':tag',$tag, PDO::PARAM_STR); 
                $tagInsert->execute();
                $tagId=$db->lastInsertId();
                // echo $tag."は".$tagId."になりました";
            }else $tagId=$result['id'];

            //tag_mapに追加
            $insertTagmap = $db->prepare("
                INSERT IGNORE INTO tag_map (articleId,tagid) VALUES (:articleId,:tagId)                
            ");
            $insertTagmap->bindValue(':articleId',$id, PDO::PARAM_STR); 
            $insertTagmap->bindValue(':tagId',$tagId, PDO::PARAM_STR); 
            $insertTagmap -> execute();
        }
        return true;

    }catch (PDOExcption $e) {
        error($e." Writiing database was failed.");
        return false;
    }
}

function write_db($title,$content,$tags){
    $tags= explode(",", $tags);
    $tags = array_unique($tags);
    // echo "関数内部<br>";
    // echo $title."<br>";
    // echo $content."<br>";
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("
            INSERT INTO articles (title,content,date)
            VALUES(:title,:content,now())
        ");
        $stmt->bindValue(':title',$title, PDO::PARAM_STR);
        $stmt->bindValue(':content',$content, PDO::PARAM_STR);
        $stmt->execute();
        $articleId = $db->lastInsertId();

        //タグがtagテーブルに存在するか
        $tagId=-1;
        foreach($tags as $tag){
            if(trim($tag)=="")continue;
            $isExistsTag = $db->prepare("
                SELECT id FROM tag WHERE  name = :tag
            ");
            $isExistsTag->bindValue(':tag',$tag, PDO::PARAM_STR); 
            $isExistsTag->execute();
            $result=$isExistsTag->fetch();
            
            if($result==false){
                $tagInsert = $db->prepare("
                    INSERT INTO tag (name) VALUES (:tag)
                ");
                $tagInsert->bindValue(':tag',$tag, PDO::PARAM_STR); 
                $tagInsert->execute();
                $tagId=$db->lastInsertId();
                // echo $tag."は".$tagId."になりました";
            }else $tagId=$result['id'];

            $insertTagMap = $db->prepare("
                INSERT INTO tag_map (articleId,tagId) VALUES (:articleId,:tagId);
            ");
            $insertTagMap->bindValue(':articleId',$articleId, PDO::PARAM_STR); 
            $insertTagMap->bindValue(':tagId',$tagId, PDO::PARAM_STR); 
            $insertTagMap->execute();
        }
        return $articleId;

    }catch (PDOExcption $e) {
        error($e." Writiing database was failed.");
        return false;
    }
}
?>
