<?php
  require "../config/setting.php";
  require "../functions/read_db.php";
  require "../functions/write_db.php";
  require "../functions/search_db.php";
  require "../login/loginCheck.php";
  my_session_start();
?>
<!DOCTYPE html>
<head lang="jp">
  <head>
    <meta charset="utf-8">

    <link rel="icon" type="image/x-icon" href="../img/fav.png">
    <link rel="apple-touch-icon"  href="../img/fav.png">    


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>フジログリンク</title>
    <meta name="description" content="フジログリンク">
    <meta name="author" content="Fuji">

    <!-- jQuery読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- BootstrapのCSS読み込み -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- BootstrapのJS読み込み -->
    <script src="../js/bootstrap.min.js"></script>

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
              <a class="nav-link" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../profile/">Profile</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Link<span class="sr-only">(current)</span></a>
            </li>
            <?php
              if (isset($_SESSION['id'])){
                echo '<li class="nav-item"><a class="nav-link" href="../edit/">Post</a></li>';
              }
            ?>
          </ul>
          <form action="../index.php" method="get" class="form-inline my-2 my-lg-0" id="searchForm">
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
            <h1 class="text-center my-font1">Link</h1>
            <ul>
              <li>
                <h3><a href="http://timecapsule1.php.xdomain.jp/TimeCapsule/">TimeCapsuleService</a> 2020/2</h3>
                <p>友人と作成した初めてのWebアプリケーション。未来へメッセージをお届けします。サーバーサイド全般を担当しました。</p>
              </li>

              <li>
                  <h3><a href="https://lemniscatern.github.io/minigames/">短期単発ネタ開発シリーズ</a> 2020/6-</h3>
                  <ul>
                    <li>
                      <p><a href="https://lemniscatern.github.io/minigames/string/">String(ストリング)</a> 2020/6</p>
                      <p>オンライン飲み会を楽しむ為のミニゲーム。推奨人数3人以上、1ゲーム10分程度</p>
                    </li>
                    <li>
                      <p><a href="https://lemniscatern.github.io/minigames/mackerel/">Mackerel（マカレル)</a> 2021/3</p>
                      <p>Mackerel仙人があなたを理想の年齢にしてくださいます。（実年齢を任意の年齢＋月で表示する。）</p>
                    </li>
                  </ul>                  
              </li>
            </ul>
    
          <!-- ここまでcol-9の左エリア -->
          </div>


          <div class="col-sm-3 border-left">

            <div class="row justify-content-left">
              <div class="col-sm-auto">
                <h3>タグ</h3>
                <ul class="text-left">
                  <?php
                    getPopularTags('../index.php');
                  ?>  
                </ul>
              </div>
            </div>

            <div class="row justify-content-left">
              <div class="col-sm-auto">
                <h3>アーカイブ</h3>
                <ul class="text-left">
                  <?php
                      getEveryOtherMonthArticles('../index.php');
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


    <footer class="text-center" style="background-color:#6699CC;">© 2022 Fuji
      <?php
          if (isset($_SESSION['id'])){
            echo '<a href="../login/logout.php">ログアウト</a>';
            echo '<input type="hidden" name="token" value="token">';
          }else{
            echo '<a href="../login/index.php">ログイン</a>';
          }
      ?>
    </footer>

  </body>
</html>


<script>
$('#searchForm').submit(function() {
  if(!$("#searchInput").val().trim())return false;
});
</script>