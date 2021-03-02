<?php
  require "../config/setting.php";
  require "../functions/read_db.php";
  require "../functions/write_db.php";
  require "../functions/search_db.php";
  require "../functions/hs.php";
  require "../login/loginCheck.php";
  

  my_session_start();

  function loca(){
    header('Location:../index.php'); 
  }

  
  if (isset($_SESSION['id'])==false)loca();

  $articleId="-1";
  $title="";
  $date="";
  $content="";
  $tags=array();
  if(filter_input(INPUT_GET,"tag")!=null){
    $tags=array($_GET['tag']=>0);
  }
  
  $page=filter_input(INPUT_GET,"page")==null?0:filter_input(INPUT_GET,"page");

  
  if(is_numeric(filter_input(INPUT_GET,'articleId'))==false);
  else{
    $articleArray=getArticleById($_GET['articleId'],$page);
    if($articleArray!=false){
      $articleId=$_GET['articleId'];
      $title = $articleArray["title"];
      $date = $articleArray["date"];
      $content = $articleArray["content"];
      $tags = $articleArray["tags"];
    }
  }

  
  $token=bin2hex(random_bytes(24));
  $_SESSION['token']=$token;
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="../img/fav.png">
    <link rel="apple-touch-icon"  href="../img/fav.png">   
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>記事の編集画面</title>
    <meta name="description" content="情報系大学生によるポートフォリオを兼ねたプログラミング関連の雑記メモ">
    <meta name="author" content="Fuji">

    <!-- jQuery読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- BootstrapのCSS読み込み -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- BootstrapのJS読み込み -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- MathJax https://www.mathjax.org/#gettingstarted -->
    <!-- headではなく、末尾で読むとうまくいくっぽい？ -->
    

    
    

    <!-- Marked https://marked.js.org/ -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <!-- https://laboradian.com/how-to-use-highlightjs/ -->
    <link href="../js/highlight/styles/monokai.css" rel="stylesheet">
    <script src="../js/highlight/highlight.pack.js"></script>

    <!-- ロゴ様フォント,本文フォント -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <!-- font用class読み込み -->
    <link href="../font.css" rel="stylesheet">
    <link href="../css/my-mathjax.css" rel="stylesheet">




  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#6699CC;">
        <h1>
          <a class="navbar-brand" href="#">フジログ</a>
        </h1>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="../index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../profile/">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../link/">Link</a>
            </li>
            <?php
              if (isset($_SESSION['id'])){
                echo '<li class="nav-item"><a class="nav-link" href="#">Post</a></li>';
              }
            ?>
          </ul>
          <form action="edit_comp.php" method="get" class="form-inline my-2 my-lg-0" id="searchForm" >
            <input class="form-control mr-sm-2" name="words" type="search" placeholder="Search Article" aria-label="Search" id="searchInput">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>

    

    <main class="bg-secondary">
      <div class="container bg-light">
        <form action="edit_comp.php" method="post" id="post" >

          <div class="row justify-content-around">
              <input class="col-11" type="text" name="title" value="<?php echo hs($title);?>">
              <input class="col-11" type="text" name="tag" rows="20"  value="<?php
                  foreach($tags as $id=>$name){
                    echo hs($id).",";
                  }
                ?>">
          </div>

          <!-- <div class="row d-flex justify-content-end">
            
          </div> -->

          
            <div class="conteiner">
              <div class="row justify-content-center">
                <div class="col-6"></div>
                <div class="col-sm-6 d-flex my-1 justify-content-end align-items-baseline">
                   <!-- <div class="d-flex justify-content-end"></div> -->
                  <label><input  type="checkbox" name="preview" checked>プレビュー</label>
                  <?php
                    if($articleId!=-1)echo '<button type="button" class="btn btn-danger post-btn mx-1" name="post" value="delete">削除';
                  ?>
                  <button type="button" class="btn post-btn btn-outline-dark mx-1" name="post" value="post">投稿
                  <input type="hidden" name="token" value="<?php echo $token;?>">
                  <input type="hidden" name="articleId" value="<?php echo $articleId;?>">
                  <input name="key" type="hidden" value="post">
                </div>

              </div>
            </div>

          <div class="row">
              <textarea class="col-6"  rows="20" id="input" name="content"><?php echo $content; ?></textarea>
              <div class="col-6" id="output"></div>
          </div>
        

        </form>

        <div class="container bg-light">
          <div class="text-right">
            <button class="text-right m-2 btn btn-outline-dark" onclick="$(window).scrollTop(0);">ページ上部へ</button>
          </div>
        </div>
        
        
      </div>

      
    </main>


    <footer class="text-center" style="background-color:#6699CC;">© 2022 Fuji
      <?php
          if (isset($_SESSION['id'])){
            echo '<a href="../login/logout.php">ログアウト</a>';
            echo '<input type="hidden" name="token" value="token">';
          }
      ?>
    </footer>

  </body>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
  <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
  <script src="mdToHTML.js"></script>
</html>


<script>
$('#searchForm').submit(function() {
  if(!$("#searchInput").val().trim())return false;
});

$('.post-btn').click(function(){
  ok=true;
  $('input[name=key]').val($(this).val());
  if($('input[name="title"]').val().trim()=="")ok=false;
  if($('textarea[name="content"]').val().trim()=="")ok=false;
  
  if(!ok){
    alert("タイトルとコンテンツは必須です。");
    return false;
  }
  if($('input[name=key]').val()=="delete")ok=confirm("本当に削除しても宜しいですか？");
  if(ok)$('#post').submit();
});


//thanks https://deecode.net/?p=1104
function onTextAreaKeyDown(event, object) {
    // キーコードと入力された文字列
    var keyCode = event.keyCode;
    var keyVal = event.key;

    // カーソル位置
    var cursorPosition = object.selectionStart;
    // カーソルの左右の文字列値
    var leftString = object.value.substr(0, cursorPosition);
    var rightString = object.value.substr(cursorPosition, object.value.length);

    // タブキーの場合
    if(keyCode === 9) {
        event.preventDefault();  // 元の挙動を止める
        // textareaの値をカーソル左の文字列 + タブスペース + カーソル右の文字列にする
        object.value = leftString + "\t" + rightString;
        // カーソル位置をタブスペースの後ろにする
        object.selectionEnd = cursorPosition + 1;
    }
    // かぎかっこの場合の自動補完
    else if(keyVal === "{") {
        event.preventDefault();  // 元の挙動を止める
        // textareaの値をカーソル左の文字列 + {} + カーソル右の文字列にする
        object.value = leftString + "{}" + rightString;
        // カーソル位置をタブスペースの後ろにする
        object.selectionEnd = cursorPosition + 1;
    }
    // かっこの場合の自動補完
    else if(keyVal === "[") {
        event.preventDefault();  // 元の挙動を止める
        // textareaの値をカーソル左の文字列 + [] + カーソル右の文字列にする
        object.value = leftString + "[]" + rightString;
        // カーソル位置をタブスペースの後ろにする
        object.selectionEnd = cursorPosition + 1;
    }
}

// テキストエリアのキー入力時の関数を設定
document.getElementById("input").onkeydown = function(event) {onTextAreaKeyDown(event, this);}

</script>