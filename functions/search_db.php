<?php

function day_search_db($date,$page){
    if(is_numeric($page)==false)$page=0;
    if($page<0)$page=0;
    $preg = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';//日
    if(!preg_match($preg, $date))return false;
    {
        $sql1 = '
        SELECT * FROM
            (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
                (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                    (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
                GROUP BY articleId) AS subq2 
            ON articles.id = articleId) as subq3 
        WHERE date="'.$date.'"';

        $sql2 = '
        SELECT * FROM
            (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
                (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                    (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
                GROUP BY articleId) AS subq2 
            ON articles.id = articleId) as subq3 
        WHERE date="'.$date.'" ORDER BY date DESC LIMIT '.($page*10).',10';
    }
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $count = $db ->query($sql1);
        $count = $count -> rowCount();
        $stmt=$db ->query($sql2);
        $rows=[];
        $key=0;
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $rows+=array($key=>$result);
            $key++;
        }
        $rows+=array("count"=>$count);
        return $rows;
    }catch (PDOExcption $e) {
        echo "erro";
        error($e." Writiing database was failed.");
        return false;
    }
}

function month_search_db($date,$page){
    if(is_numeric($page)==false)$page=0;
    if($page<0)$page=0;
    $preg = '/^[0-9]{4}-[0-9]{2}$/';//日
    if(!preg_match($preg, $date))return false;
    {
        $sql1 = '
        SELECT * FROM
            (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
                (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                    (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
                GROUP BY articleId) AS subq2 
            ON articles.id = articleId) as subq3 
        WHERE date BETWEEN "'.$date.'-00'.'" AND "'.$date.'-31"';

        $sql2 = '
        SELECT * FROM
            (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
                (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                    (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
                GROUP BY articleId) AS subq2 
            ON articles.id = articleId) as subq3 
        WHERE date BETWEEN "'.$date.'-00'.'" AND "'.$date.'-31" '.' ORDER BY date DESC LIMIT '.($page*10).',10';
    }
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $count = $db ->query($sql1);
        $count = $count -> rowCount();
        $stmt=$db ->query($sql2);
        $rows=[];
        $key=0;
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $rows+=array($key=>$result);
            $key++;
        }
        $rows+=array("count"=>$count);

        // echo $rows['count']."<br>";
        // foreach($rows as $row){
        //     echo "Id:".$row['id']."<br>";
        // }

        return $rows;
    }catch (PDOExcption $e) {
        echo "erro";
        error($e." Writiing database was failed.");
        return false;
    }
}



function year_search_db($date,$page){
    if(is_numeric($page)==false)$page=0;
    if($page<0)$page=0;
    $preg = '/^[0-9]{4}$/';//年
    if(!preg_match($preg, $date))return false;
    {
        $sql1 = '
        SELECT * FROM
            (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
                (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                    (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
                GROUP BY articleId) AS subq2 
            ON articles.id = articleId) as subq3 
        WHERE date BETWEEN "'.$date.'-01-01'.'" AND "'.$date.'-12-31"';

        $sql2 = '
        SELECT * FROM
            (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
                (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                    (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
                GROUP BY articleId) AS subq2 
            ON articles.id = articleId) as subq3 
        WHERE date BETWEEN "'.$date.'-01-01'.'" AND "'.$date.'-12-31" '.' ORDER BY date DESC LIMIT '.($page*10).',10';
    }
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $count = $db ->query($sql1);
        $count = $count -> rowCount();
        $stmt=$db ->query($sql2);
        $rows=[];
        $key=0;
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $rows+=array($key=>$result);
            $key++;
        }
        $rows+=array("count"=>$count);

        // echo $rows['count']."<br>";
        // foreach($rows as $row){
        //     echo "Id:".$row['id']."<br>";
        // }
        return $rows;
    }catch (PDOExcption $e) {
        echo "erro";
        error($e." Writiing database was failed.");
        return false;
    }
}

function word_search_db($words,$page){    
    if(is_numeric($page)==false)$page=0;
    if($page<0)$page=0;

    // echo "中身:".$words;
    
    //日付検索、タグ検索か
    $result=year_search_db($words,$page); if($result!=false)return $result;
    $result=month_search_db($words,$page); if($result!=false)return $result;
    $result=day_search_db($words,$page); if($result!=false)return $result;
    $result=tag_search_db($words,$page); if($result!=false)return $result;

    //フリーワード検索　5つまで
    $words= explode(" ", $words);//スペース区切で配列に
    $words = array_slice($words,0,4);

    $keywords = [];
    foreach ($words as $keyword) {
        $keyword = addslashes((string)$keyword);//クオート類のエスエーぷ
        if($keyword=="")continue;
        if($keyword=="%")$keyword="¥%";
        if($keyword=="_")$keyword="¥_";
        $keywords[] = 'title LIKE "%' . $keyword . '%"';
        $keywords[] = 'tags LIKE "%' . $keyword . '%"';
        $keywords[] = 'content LIKE "%' . $keyword . '%"';
    }
    
    $keywords= implode(" OR ", $keywords);

    // echo $keywords."<br>";
    $sql1 = 
    "SELECT * FROM 
        (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
            (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
            GROUP BY articleId) AS subq2  
        ON articles.id = articleId) as subq3 
    WHERE ".$keywords." ORDER BY date DESC LIMIT ".$page.",10";

    $sql2 = 
    "SELECT * FROM 
        (SELECT id,title,content,date,tags FROM articles LEFT JOIN 
            (SELECT articleId , GROUP_CONCAT(name) as tags FROM 
                (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
            GROUP BY articleId) AS subq2  
        ON articles.id = articleId) as subq3 
    WHERE ".$keywords;
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // echo $sql2;
        $stmt = $db->query($sql2);
        // $stmt->execute();   
        $count = $stmt -> rowCount();

        $stmt = $db->query($sql1);
        // $stmt->execute();   

        $rows=[];
        $key=0;
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $rows+=array($key=>$result);
            $key++;
        }
        $rows+=array("count"=>$count);
        // displayArticleList($stmt);
        return $rows;
    }catch (PDOExcption $e) {
        echo "erro";
        error($e." Writiing database was failed.");
        return false;
    }
}



function tag_search_db($tag,$page){
    if(is_numeric($page)==false)$page=0;
    if($page<0)$page=0;
    $preg = '/^#\S+$/';
    if(!preg_match($preg, $tag))return false;
    
    $tag=explode("#", $tag)[1]; 
    
    try {
        $db= new PDO(call_dsn(), call_user(),call_password());
        //SQLインジェクション対策
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        // //エラー発生で例外を投げる
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        //ヒット件数の取得
        $stmt = $db->prepare('
            SELECT id,title,content,tags,date FROM 
                (SELECT * FROM  articles WHERE EXISTS
                    (SELECT * FROM 
                        (SELECT articleId as ai FROM tag_map WHERE tagId= (SELECT id FROM tag WHERE name=:tag) ) AS subq1
                    WHERE articles.id= ai)) As subq2 
                JOIN  (SELECT articleId , GROUP_CONCAT(name) as tags FROM (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
            GROUP BY articleId) AS subq3 ON id=articleId
        ');
        $stmt->bindValue(':tag',$tag, PDO::PARAM_STR); 
        $stmt->execute();
        $count = $stmt -> rowCount();
  
        $stmt = $db->prepare('
            SELECT id,title,content,tags,date FROM 
                (SELECT * FROM  articles WHERE EXISTS
                    (SELECT * FROM 
                        (SELECT articleId as ai FROM tag_map WHERE tagId= (SELECT id FROM tag WHERE name=:tag) ) AS subq1
                    WHERE articles.id= ai)) As subq2 
                JOIN  (SELECT articleId , GROUP_CONCAT(name) as tags FROM (SELECT tag_map.articleId , tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS subq 
            GROUP BY articleId) AS subq3 ON id=articleId ORDER BY date DESC LIMIT :page,10
        ');
        $stmt->bindValue(':tag',$tag, PDO::PARAM_STR); 
        $stmt->bindValue(':page',$page*10, PDO::PARAM_STR); 
        $stmt->execute();
        
        $rows=[];

        $key=0;
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $rows+=array($key=>$result);
            $key++;
        }
        $rows+=array("count"=>$count);
        return $rows;
    }catch (PDOExcption $e) {
      error($e." Writiing database was failed.");
      return false;
    }
  }


?>
