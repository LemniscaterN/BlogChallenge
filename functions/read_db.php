<?php
//https://gray-code.com/php/getting-data-by-using-pdo/


function getPopularTags($to){
  try {
    $db= new PDO(call_dsn(), call_user(),call_password());
    //SQLインジェクション対策
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    // //エラー発生で例外を投げる
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $res = $db->query("
      SELECT name,Count(*)  AS eachCnt FROM (SELECT tagId,tag.name FROM tag_map JOIN tag ON tag_map.tagId = tag.id) AS Subeuery　 GROUP BY tagId ORDER BY `eachCnt`  DESC LIMIT 15
    ");
    foreach( $res as $row ) {
		    echo '<li><a href="'.$to.'?words='.urlencode('#'.$row["name"]).'">'.htmlspecialchars($row["name"])."($row[eachCnt])".'</a></li>';        
	  }
    return true;
  }catch (PDOExcption $e) {
    // echo("エラー:".$e->getMessage());
    error($e." Writiing database was failed.");
    return false;
  }
}

function getEveryOtherMonthArticles($to){
  try {
    $db= new PDO(call_dsn(), call_user(),call_password());
    //SQLインジェクション対策
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    // //エラー発生で例外を投げる
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $res = $db->query("
        SELECT date,COUNT(*) as count FROM 
          (SELECT DATE_FORMAT(date, '%Y-%m') AS date FROM articles) As subq1 
        GROUP BY date
    ");
    foreach( $res as $row ) {
		    echo '<li><a href="'.$to.'?words='.$row["date"].'">'."$row[date]($row[count])</a></li>";        
	  }
    return true;
  }catch (PDOExcption $e) {
    // echo("エラー:".$e->getMessage());
    error($e." Writiing database was failed.");
    return false;
  }
};

function getArticleById($id){
  if(!is_numeric($id))return false;
  try {
    $db= new PDO(call_dsn(), call_user(),call_password());
    //SQLインジェクション対策
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    // //エラー発生で例外を投げる
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $info1 = $db->prepare("
      SELECT * FROM articles WHERE id = :id
    ");
    $info1->bindValue(':id',$id, PDO::PARAM_INT);
    $info1->execute();
    $info1=$info1->fetch(PDO::FETCH_ASSOC);
    if($info1==false)return false;

    $info2 = $db->prepare("
      SELECT tag.id,name FROM tag RIGHT JOIN (SELECT * FROM `tag_map` WHERE articleId=:id) AS subq ON tag.id=tagId
    ");
    $info2->bindValue(':id',$id, PDO::PARAM_INT);
    $info2->execute();
    $info2=$info2->fetchAll(PDO::FETCH_ASSOC);
    
    $tags=[];
    foreach($info2 as $key => $value){
      $tags += array($value["name"] => $value["id"]);
    }
    // echo var_dump($info1).":info2<br>";

    $info1+=array('tags'=>$tags);
    return $info1;
  }catch (PDOExcption $e) {
    error($e." Writiing database was failed.");
    return false;
  }
}

?>
