<?php
  require "../config/setting.php";
  require "../functions/read_db.php";
  require "../functions/write_db.php";
  require "../functions/search_db.php";
  $words="";
  if(isset($_GET['words'])){
    $words = $_GET['words'];
  }
  echo "ワード：".$words;

  
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
      <?php if($words!="")echo htmlspecialchars($words)."の検索結果";else echo"フジブログ";?>
    </title>
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

    <script src="../myjs/mdToHTML.js"></script>

  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#6699CC;">
        <h1>
          <a class="navbar-brand" href="#">フジログ</a>
        </h1>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler1">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
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
          
          <div class="col-sm-9">
            <h1>
              <?php if($words!="")echo "「".htmlspecialchars($words)."」の検索結果";else echo'Home <small class="text-muted">ホーム</small>';?>
            </h1>
          
            <!-- <img src="./img/img1.png" class="img-fluid" alt="Home imgage"> -->
            <?php
              if($words==""){
                echo "<p>こちらはフジさんによるフジさんの為のポートフォリオ兼ブログです</p>";
                echo "<p>主に趣味の競プロ関連のメモ、プログラミング関連で詰まった箇所をまとめる予定です。</p>";
              }else{
                echo '<div class="list-group">';
                if($words!=""){
                  word_search_db($words);
                }
                echo '</div>';
              }
            ?>
            

          </div>

          <div class="col-sm-3 border-left">

            <div class="row justify-content-left">
              <div class="col-sm-auto">
                <h3>タグ</h3>
                <ul class="text-left">
                  <?php
                    getPopularTags();
                  ?>  
                </ul>
              </div>
            </div>

            <div class="row justify-content-left">
              <div class="col-sm-auto">
                <h3>アーカイブ</h3>
                <ul class="text-left">
                  <?php
                      getEveryOtherMonthArticles();
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
        </div>
      </div>
      
    </main>


    <footer class="text-center" style="background-color:#6699CC;">© 2022 Fuji</footer>

  </body>

</html>

<script>
$('#searchForm').submit(function() {
  if(!$("#searchInput").val().trim())return false;
});
</script>