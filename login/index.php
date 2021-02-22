<?php
  require "../config/setting.php";
  require "../functions/read_db.php";
  require "../functions/write_db.php";
  require "../functions/search_db.php";
  require "loginCheck.php";
  my_session_start();

  if (isset($_SESSION['id'])) {
      header('Location:../index.php'); 
  }
  else if( isset($_POST['name']) && isset($_POST['password']) ){
    if(login()==true){
      header('Location:../index.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">

    <link rel="icon" type="image/x-icon" href="../img/fav.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/fav.png">    
    
    <!-- タイトルに飛ばす-->
    <meta property="og:url" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/index.php" />
    <meta property="og:title" content="フジログログインページ" />
    <meta property="og:description" content="ふじ専用ログインページ" />
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="フジログ"/>
    <meta property="og:image" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/img/icon.png" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@s1870262" />
    <meta name="twitter:image" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/img/icon.png" />
    <meta name="twitter:description" content="情報系大学生ふじによるポートフォリオを兼ねたゆるいブログ" />


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>フジログ　ログインページ</title>
    <meta name="description" content="情報系大学生によるポートフォリオを兼ねたプログラミング関連の雑記メモ">
    <meta name="author" content="Fuji">

    <!-- jQuery読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- BootstrapのCSS読み込み -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- BootstrapのJS読み込み -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- MathJax https://www.mathjax.org/#gettingstarted -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <!-- Marked https://marked.js.org/ -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <!-- https://laboradian.com/how-to-use-highlightjs/ -->
    <link href="../js/highlight/styles/monokai.css" rel="stylesheet">
    <script src="../js/highlight/highlight.pack.js"></script>

    <link href="login.css" rel="stylesheet">
    <script src="login.js"></script>

    <!-- ロゴ様フォント,本文フォント -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <!-- font用class読み込み -->
    <link href="../font.css" rel="stylesheet">

  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#6699CC;">
        <h1>
          <a class="navbar-brand" href="../index.php">フジログ</a>
        </h1>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="../index.php">Home</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../profile/">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../link/">Link</a>
            </li>
          </ul>
          
          <form action="index.php" method="get" class="form-inline my-2 my-lg-0" id="searchForm" >
            <input class="form-control mr-sm-2" name="words" type="search" placeholder="Search Article" aria-label="Search" id="searchInput">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>

    <main class="bg-secondary">
      <div class="container bg-light">
        <div class="row">
          <div class="col-sm-12">
            <div class="container">
            <div class="login-container">
              
              <div class="avatar">
                <!--クローバー-->
                <div id="main-lap" class="load">
                  <div class="clover-left-top clover"></div>
                  <div class="clover-right-top clover"></div>
                  <div class="clover-left-buttom clover"></div>
                  <div class="clover-right-buttom clover"></div>
                </div>
              </div>
              <div class="form-box">
                  <form action="index.php" method="post" id="loginform">
                      <div id="output"></div>
                      <input name="name" type="text" placeholder="username">
                      <input name="password" type="password" placeholder="password">
                      <button class="btn btn-info btn-block login" type="submit">Login</button>
                  </form>
              </div>
        </div>
            </div>
          </div>

        </div>
      </div>
      
    </main>


    <footer class="text-center" style="background-color:#6699CC;">© 2022 Fuji
      <?php
        if (isset($_SESSION['id'])){
          echo '<a href="logout.php">ログアウト</a>';
          echo '<input type="hidden" name="token" value="token">';
        }else{
          echo '<a href="index.php">ログイン</a>';
        }
      ?>
    </footer>

  </body>
  
  
</html>


<script>
$('#searchForm').submit(function() {
  if(!$("#searchInput").val().trim())return false;
});

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

let escapeHTML = function (str) {
  return str
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;');
};

document.querySelectorAll('pre code').forEach((block) => {    
    block.innerHTML=escapeHTML(block.innerHTML);
    hljs.highlightBlock(block);
});

document.querySelectorAll('article').forEach((block) => {    
    console.log("OK:"+block);
    let html = marked(block.innerHTML);
    block.innerHTML=html;
});

$('#searchForm').submit(function() {
  if(!$("#searchInput").val().trim())return false;
});
</script>