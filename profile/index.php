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

    <meta property="og:url" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/profile/index.php"/>
    <meta property="og:title" content="フジログプロフィール"/>
    <meta property="og:description" content="フジログ製作者フジのプロフィール"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="フジログ"/>
    <meta property="og:image" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/img/icon.png"/>

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@s1870262" />
    <meta name="twitter:image" content="http://fujiweb08.php.xdomain.jp/BlogChallenge/img/icon.png" />
    <meta name="twitter:description" content="フジログ製作者フジのプロフィール" />


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>フジログプロフィール</title>
    <meta name="description" content="フジログ作者のプロフィール">
    <meta name="author" content="Fuji">

    <!-- jQuery読み込み -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- BootstrapのCSS読み込み -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- BootstrapのJS読み込み -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- font用class読み込み -->
    <link href="../font.css" rel="stylesheet">
    <!-- ロゴ様フォント -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
     
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
            <li class="nav-item  active">
              <a class="nav-link" href="#">Profile<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="../link/">Link</a>
            </li>
            <?php
              if (isset($_SESSION['id'])){
                echo '<li class="nav-item"><a class="nav-link" href="../edit/">Post</a></li>';
              }
            ?>
          </ul>
          <form action="../index.php" method="get" class="form-inline my-2 my-lg-0" id="searchForm">
            <input class="form-control mr-sm-2" maxlength='20' name="words" type="search" placeholder="Search Article" aria-label="Search" id="searchInput">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>

    <main class="bg-secondary">
      <div class="container bg-light">
        <div class="row">

          <div class="col-sm-9">    

            <h1 class="text-center my-font1">Profile</h1>
            
            <div class="mt-2 d-flex justify-content-around">
              <!-- <img class="p-3" src="../img/php-icon.svg" height="90" alt="prifile-img"> -->
              <div class="border border-info mr-4" style="height : 150px;">
                <h3 class="m-4"  style="transform: rotate(-40deg);">No image!</h3>
              </div>
              
              <div class="flex-fill">
                <h3>
                  フジ
                </h3>
                <p>地方国立大学の情報系学部生です。ネットに実名や大学名を公開するのはどうも不用心に思えたので、主に自身のスキルや資格についてです。スキルは★☆☆☆☆(ほぼ初心者)から★★★★★(十分に使いこなせている)の5段階です。</p>
              </div>
            </div>


            <div class="container mt-4">
              <div class="row">
                <div class="col-12"><h1 class="text-center my-font1">Main Skills</h1></div>
              </div>

              <div class="row justify-content-between">
                <div class="col-4 border rounded p-2">
                  <img style="display: block; margin: auto; max-height:90px;" class="img-fluid text-center" src="../img/php-icon.svg" alt="PHP">
                  <h5 class="text-center">PHP ★★★☆☆</h5>
                  <p>友人とWebサービスを開発した際に学習し、こちらのブログもサーバーサイドは全てPHPで作成しています。が、フレームワークの利用経験がありません。</p>
                </div>

                <div class="col-4 border rounded p-2">
                  <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/cpp-icon.svg" alt="C++">
                    <h5 class="text-center">C++ ★★★☆☆</h5>
                    <p>趣味の競プロで主に利用しており、利用頻度が最も高い言語です。競プロで利用しないライブラリや知識にはかなり疎いです。</p>
                </div>

                <div class="col-4 border rounded p-2">
                    <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/unity-icon.svg" alt="Unity">
                    <h5 class="text-center">Unity ★★★☆☆</h5>
                    <p>自由制作授業でのルービックキューブ解法出力アプリ、友人とのゲーム開発のほか、現在個人制作を検討しています。</p>
                </div>      
              </div>
              
              <div class="row justify-content-between">
                <div class="col-12"><h1 class="text-center my-font1">Sub Skills</h1></div>
                <div class="col-4 border rounded p-2">
                  <img style="display: block; margin: auto; max-height:90px;" class="img-fluid text-center" src="../img/python-icon.svg" alt="Python">
                  <h5 class="text-center">Python ★★★☆☆</h5>
                  <p>DSとKaggle興味があり、関連ライブラリと基本構文を一通り学習しました。利用頻度が低く、あやふやな知識が多くなっています。</p>
                </div>

                <div class="col-4 border rounded p-2">
                  <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/js-icon.svg" alt="C++">
                    <h5 class="text-center">Javascript ★★★☆☆</h5>
                    <p>基本的な構文は一通り学習しました。開発インターンにてNode.jsの利用経験があります。</p>
                </div>

                <div class="col-4 border rounded p-2">
                  <img style="display: block; margin: auto; max-height:90px;" class="img-fluid text-center" src="../img/html-icon.svg" alt="HTML">
                  <h5 class="text-center">HTML ★★☆☆☆</h5>
                  <p>SEOは未学習です。適切なタグを利用できているのか不安です。</p>
                </div>
              </div>

              <div class="row justify-content-around mt-2">
                <div class="col-4 border rounded p-2">
                    <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/java-icon.svg" alt="Java">
                    <h5 class="text-center">Java ★☆☆☆☆</h5>
                    <p>大学のオブジェクト指向の講義に利用しました。基礎構文が怪しいレベルです。</p>
                </div> 
                
                <div class="col-4 border rounded p-2">
                  <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/css-icon.svg" alt="CSS">
                    <h5 class="text-center">CSS ★★☆☆☆</h5>
                    <p>基本的な書き方は一通り学習しましたが、思ったような配置やデザインにすることがなかなか出来ません。</p>
                </div>

                <div class="col-4 border rounded p-2">
                    <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/r-icon.svg" alt="R">
                    <h5 class="text-center">R ★☆☆☆☆</h5>
                    <p>大学の画像処理の講義で利用しました。正直なところ、Rを利用する強みが分かりません。。</p>
                </div>      
              </div>

            </div>

            <div class="row mt-4 justify-content-around">
              <div class="col-12"><h1 class="text-center my-font1">Other Skill</h1></div>
              <div class="col-5 border rounded p-2">
                    <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/git-icon.svg" alt="Git">
                    <h5 class="text-center">GitHub ★★☆☆☆</h5>
                    <p>pushやcommit、pullなど基礎的な使用法は把握していますが、ブランチモデルは利用経験がありません。
                      URLは<a href="https://github.com/LemniscaterN">こちら</a>。</p>
              </div>  
              <div class="col-5 border rounded p-2">
                    <img style="display: block; margin: auto; max-height:90px;" class="img-fluid" height="90" src="../img/comm-icon.svg" alt="Communication">
                    <h5 class="text-center">コミュニケーション ★★★★☆</h5>
                    <p>ホテルや結婚式場での配膳の派遣アルバイトを2年間経験し、表彰状も戴きました。初対面の人とも自然に会話が出来ると思います。</p>
              </div>  
            </div>


            <div class="row mt-4">
                <div class="col-12"><h1 class="text-center my-font1">Qualification</h1></div>
                <ul>
                  <li>
                    <h5>ITパスポート　2019/7取得</h5>  
                    <p>「ITを利活用するすべての社会人・これから社会人となる学生が備えておくべき、ITに関する基礎的な知識が証明できる国家試験」　基本情報の前座として学習しました。</p>
                  </li>
                  <li>
                    <h5>アルゴリズム実技検定　BEGINNER 2020/5取得</h5>
                    <p>「単純なプログラムであれば自力で構築できることを証明するランク」です。個人的に不服なのでAtCoder水色になったらリベンジ予定です。</p>
                  </li>
                  <li>
                    <h5>G検定　2020/7取得</h5>
                    <p>「ディープラーニングの基礎知識を有し、適切な活用方針を決定して、事業活用する能力や知識を有しているかを検定する。」</p>
                  </li>
                  <li>
                    <h5>普通自動車第一種運転免許　2020/9取得</h5>
                  </li>
                  <li>
                    <h5>基本情報技術者試験　2021/2受験</h5>
                    <p>「高度IT人材となるために必要な基本的知識・技能をもち、実践的な活用能力を身に付けた者」です。結果待ちです。</p>
                  </li>
                </ul>
            </div>

            <div class="row mt-4 mx-2">
              <div class="col-12"><h1 class="text-center my-font1">Hobby</h1></div>
              <p>インドア的な趣味は競技プログラミング、料理、ゲーム、音楽(歌う&聞く)、etc...。趣味がかなり広いです。競プロは<a href="https://atcoder.jp/?lang=ja">AtCoder</a>にて緑(私の実績は<a href="https://atcoder.jp/users/s1870262">コチラ</a> )です。水色目指して精進しています。 </p>
              <p>アウトドア的な趣味はサイクリングです。2年のGWに下宿から200数十km離れた実家へ1日で帰省したほか、3年連続で琵琶湖一周しています。2020年は外出自粛で家での時間が多かったこともあり、筋肉の衰えを感じます。運動せねば。。</p>
            </div>


            


            
            
            
            
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