<?php
  require "config/setting.php";
  require "functions/read_db.php";
  require "functions/write_db.php";
  require "functions/search_db.php";
  require "login/loginCheck.php";

  my_session_start();
  $searchWords="";
  
  $articleId="";
  $title="";
  $date="";
  $tags="";
  $content="";
  
  $page=(int)filter_input(INPUT_GET,'page');
  if(is_numeric($page)==false)$page=0;
  if($page<0)$page=0;
  
  switch(1):
    case 1:
      if(is_numeric(filter_input(INPUT_GET,'articleId'))==true){
          if(filter_input(INPUT_GET,'articleId')>=0){
            $articleArray=getArticleById($_GET['articleId']);
            if($articleArray!=false){
              $articleId=$_GET['articleId'];
              $title = $articleArray["title"];
              $date = $articleArray["date"];
              $content = $articleArray["content"];
              $tags = $articleArray["tags"];
              break;
            }
          }
      }
    case 1:
      if(isset($_GET['words'])){ 
         $searchWords=filter_input(INPUT_GET,'words');
         if(mb_strlen($searchWords)>30)$searchWords=mb_substr($searchWords,0,30);
      }
  endswitch;

  // echo 'http://localhost:8080/'.$_SERVER['REQUEST_URI'];

  
?>

<!DOCTYPE html>
<head lang="jp" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
  <head>
    <meta charset="utf-8">

    <link rel="icon" type="image/x-icon" href="img/fav.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/fav.png">    
    
    <meta property="og:url" content="<?php 
        echo 'http://fujiweb08.php.xdomain.jp'.$_SERVER['REQUEST_URI'];
      ?>" />

    <!-- このページの名前 -->
    <meta property="og:title" content="<?php 
        if($articleId!="")echo htmlspecialchars($title).'-フジログ';
        else if(($searchWords!=""))echo 'フジログ検索「'.htmlspecialchars($searchWords).'」';
        else echo "フジログホームページ";
      ?>" />

    <meta property="og:description" content="<?php
        if($articleId!="")echo htmlspecialchars(mb_substr($content,0,30).(mb_strlen($content)>30?'...':''));
        else echo "情報系大学生ふじによるポートフォリオを兼ねたゆるいブログ";
      ?>"
    />
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="フジログ"/>
    <meta property="og:image" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/img/icon.png"/>

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@s1870262" />
    <meta name="twitter:image" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/img/icon.png" />
    <meta name="twitter:description" content="<?php
        if($articleId!="")echo htmlspecialchars(mb_substr($content,0,30).(mb_strlen($content)>30?'...':''));
        else echo "情報系大学生ふじによるポートフォリオを兼ねたゆるいブログ";
      ?>"
    />
    

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php if($searchWords!="")echo htmlspecialchars($searchWords)."の検索結果";
            else if($articleId!="")echo htmlspecialchars($title);
            else echo"フジログ";
      ?></title>
    <meta name="description" content="情報系大学生によるポートフォリオを兼ねたプログラミング関連の雑記メモ">
    <meta name="author" content="Fuji">

    <!-- jQuery読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>

     <!-- font用class読み込み -->
    <link href="font.css" rel="stylesheet">
    <!-- ロゴ様フォント -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

<?php
    //検索画面でhilitされるのを防ぐ
    if($articleId!=""){
      echo '
        <!-- MathJax https://www.mathjax.org/#gettingstarted -->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    
        <!-- Marked https://marked.js.org/ -->
        <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    
        <!-- https://laboradian.com/how-to-use-highlightjs/ -->
        <link href="js/highlight/styles/monokai.css" rel="stylesheet">
        <script src="js/highlight/highlight.pack.js"></script>
      ';
    }
?> 

    <!-- オリジナル -->
    <link href="index.css" rel="stylesheet">

  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#6699CC;">
        <h1>
          <a class="navbar-brand" href="index.php">フジログ</a>
        </h1>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>        
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="index.php" <?php if($searchWords==""&&$articleId=="")echo 'style="pointer-events: none;"'?>>Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="profile/">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="link/">Link</a>
            </li>
            <?php
              if (isset($_SESSION['id'])){
                echo '<li class="nav-item"><a class="nav-link" href="./edit/">Post</a></li>';
              }
            ?>
          </ul>
          
          <form action="index.php" method="get" class="form-inline my-2 my-lg-0" id="searchForm" >
            <input class="form-control mr-sm-2"　maxlength='20' name="words" type="search" placeholder="Search Article" aria-label="Search" id="searchInput">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>

    <main class="bg-secondary">
      <div class="container bg-light">
        <div class="row">

          <div class="col-sm-9">
            <?php 
              if($searchWords!=""){
                $pageURL='./?words='.urlencode($searchWords).'&page=';

                $arts=word_search_db($searchWords,$page);
                echo "<h1>「".htmlspecialchars($searchWords)."」の検索結果:".$arts["count"]."件</h1>";

                $maxpage=(int)(($arts["count"]+9)/10-1);
                echo (min($page*10+1,($page*10+count($arts)-1)))."件目から".($page*10+count($arts)-1)."件目を表示";

                echo '<div class="list-group">';
                for($i=0;$i<count($arts)-1;$i++){
                  echo '<div class="list-group-item list-group-item-action deconone">';
                      echo '<p>'.$arts[$i]["date"].' : '.htmlspecialchars($arts[$i]["tags"]).'</p>';
                      echo '<h2><a class="text-body" href="index.php?articleId='.$arts[$i]["id"].'">'.htmlspecialchars($arts[$i]["title"]).'</a></h2>';
                      echo '<p>'. htmlspecialchars(mb_substr($arts[$i]["content"],0,100)) .'</p>';
                  echo '</div>';
                }
                echo '</div>';
                


                //ページネーション
                echo '<br>
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center">';
                echo '<li class="page-item page-item '.($page!=0?'':'active').'"><a class="page-link" href="'.$pageURL.'0'.'">1</a></li>';

                if($page>=3)echo '<li class="page-item disabled"><a class="page-link" href="#">…</a></li>';


                if($page>=2){
                  if($page  <=$maxpage)echo '<li class="page-item page-item "><a class="page-link" href="'.$pageURL.($page-1).'">'.($page).'</a></li>';
                  if($page+1<=$maxpage)echo '<li class="page-item page-item active"><a class="page-link" href="'.$pageURL.$page.'">'.($page+1).'</a></li>';
                  if($page+2<=$maxpage)echo '<li class="page-item page-item"><a class="page-link" href="'.$pageURL.($page+1).'">'.($page+2).'</a></li>';
                }else{
                  if(1  <$maxpage)echo '<li class="page-item page-item '.($page==1?'active':'').'"><a class="page-link" href="'.$pageURL.'1'.'">2</a></li>';
                  if(2  <$maxpage)echo '<li class="page-item page-item '.($page==2?'active':'').'"><a class="page-link" href="'.$pageURL.'2'.'">3</a></li>';
                }

                
                if($page+2 < $maxpage)echo '<li class="page-item disabled"><a class="page-link" href="#">…</a></li>';

                if(0!=$maxpage)echo '<li class="page-item page-item '.($page==$maxpage?'active':'').'"><a class="page-link" href="'.$pageURL.$maxpage.'">'.($maxpage+1).'</a></li>';                
                echo '
                    </ul>
                  </nav>
                ';
              }
              else if($articleId!=""){           
                echo '<h1 style="display:inline;">'.htmlspecialchars($title)."</h1>";
                echo '<p style="display:inline;">'.$date."</p>";

                if (isset($_SESSION['id']))echo '&nbsp;<a href="./edit/?articleId='.$articleId.'" style="display:inline;">編集する</a>';
                echo "<br>";

                //タグ
                foreach($tags as $name => $tagId){
                  echo '<a href="index.php?words='.urlencode("#".$name).'" style="display:inline;">'.$name." </a>";
                }
                
                //<,>をエスケープ
                $search = array('<','>');
                $replace = array('&lt;','&gt;');
                preg_match_all('/<pre><code>([\s\S]*?)<\/pre><\/code>/m', $content, $matches);
                foreach($matches[1] as $key => $value){
                    $content =  str_replace($value,str_replace($search,$replace,$value),$content);
                }
                echo "<article>".$content."</article>";

              }else{
                echo '<h1 class="text-center my-font1">Home</h1>';
                echo "<p>「既存のサイトにアウトプットするくらいなら、いっそ自分でアウトプット用のサイトを作れば作る過程もアウトプットになって一石二鳥なのでは？」<br>との考えで出来たフジさんによるフジさんの為のブログです</p>";
                echo "<p>PHP、Jaavscript、Bootstrapを利用して作成しました。</p>";
                echo '<div class="d-flex justify-content-around">
                <img src="img/php-icon.svg" height="90" alt="PHPのロゴ">
                <img src="img/js-icon.svg"  height="90" alt="JSのロゴ">
                <img src="img/boot-icon.svg"  height="90" alt="Bootstrapのロゴ">
              </div><br>';

                echo "<p>TeX形式の数式やMarkdown形式、コードハイライトが利用できることを特徴としています。</p>";
                echo "<p>主に趣味の競プロ関連のメモ、プログラミング関連で詰まった箇所をまとめる予定です。</p>";
                echo "<p><br>検索方法忘備録</p>
                <ul>
                  <li>キーワード検索　スペース区切りでOR検索<br> 例:「C++ ダイクストラ」</li>
                  <li>タグ　「#タグ名」で検索<br> 例:「#PHP」</li>
                  <li>年検索　「西暦4桁」で検索<br> 例:「2021」</li>
                  <li>月検索　「西暦4桁-月2桁」で検索<br> 例:「2021-02」</li>
                  <li>日検索　「西暦4桁-月2桁-日2桁」で検索<br> 例:「2021-02-14」</li>
                </ul>";

                

                
              }
            ?>



            
          <!-- ここまでcol-9の左エリア -->
          </div>


          <div class="col-sm-3 border-left">

            <div class="row justify-content-left">
              <div class="col-sm-auto">
                <h3>タグ</h3>
                <ul class="text-left">
                  <?php
                    getPopularTags('index.php');
                  ?>  
                </ul>
              </div>
            </div>

            <div class="row justify-content-left">
              <div class="col-sm-auto">
                <h3>アーカイブ</h3>
                <ul class="text-left">
                  <?php
                      getEveryOtherMonthArticles('index.php');
                    ?>  
                </ul>
              </div>
            </div>

            <div class="row justify-content-center">
              <div class="col-sm-auto d-none d-lg-block">
                <a class="twitter-timeline" data-lang="ja" data-width="200" data-height="300" href="https://twitter.com/s1870262?ref_src=twsrc%5Etfw">Tweets by s1870262</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>   
              </div>
            </div>

          </div>

          <div class="row">
    
          </div>

          
        </div>
      </div>
      
    </main>


    <footer class="text-center" style="background-color:#6699CC;">© 2022 Fuji
      <?php
          if (isset($_SESSION['id'])){
            echo '<a href="./login/logout.php">ログアウト</a>';
            echo '<input type="hidden" name="token" value="token">';
          }else{
            echo '<a href="./login/index.php">ログイン</a>';
          }
      ?>
    </footer>

  </body>
</html>


<script>

$('#searchForm').submit(function() {
  if(!$("#searchInput").val().trim())return false;
});


<?php 
if($articleId!=""){
  echo "$(document).ready(function(){
    MathJax = {
        startup: {
          typeset: true
        },
        tex: {
          inlineMath: [ ['$','$']],
          displayMath: [ ['$$','$$']],
          processEscapes: true
        },
        options: {
          ignoreHtmlClass: 'tex2jax_ignore',
          processHtmlClass: 'tex2jax_process'
        }
    };
  
    document.querySelectorAll('pre code').forEach((block) => {
      hljs.highlightBlock(block);
    });
  
    document.querySelectorAll('article').forEach((block) => {    
        let html = marked(block.innerHTML);
        block.innerHTML=html;
    });
  });   
  ";
}
?>




$('#searchForm').submit(function() {
  if(!$("#searchInput").val().trim())return false;
});
</script>