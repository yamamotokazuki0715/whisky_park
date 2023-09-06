<div id="inline" class="wh-exp">
  <div class="wh-exp-wrap">
    <div class="exp-img">
      <img src="images/mainvisual-bg.jpg" alt="ウイスキー">
    </div>

    <div class="exp-area">
      <h2>ウイスキーとは？</h2>
      <p>
        ウイスキーの定義はそれぞれの国によって異なっており、原料、製法、熟成年数などが各国ごとに定められていますが、一般には次のように定義されます。<br><br>

        <font color='orange'>「穀類を原料として、糖化、発酵の後に蒸溜をおこない、木製の樽で貯蔵熟成させてできるお酒」</font><br><br>

        とくに重要なのが‘木製の樽においての貯蔵熟成’
        ビールや焼酎などの製法と比べてみると分かりやすいのですが、ウイスキーは樽の中で長い年月をかけて熟成するがゆえに、深い琥珀色をしており、この熟成によってウイスキーの香りがまろやかに、そして深いコクを持つようになるのです。

        <img src="images/md-img1.jpg" alt="グラフ1">

        ウイスキーは、麦芽だけを原料にしたモルトウイスキーと、トウモロコシなどの穀物を原料にしたグレーンウイスキーの2つに分かれます。<br>
        また、さらにその2つを組み合わせたのがブレンデッドウイスキーです。<br>
        それぞれに異なる味わいと魅力をもっています。<br>

        <img src="images/md-img2.jpg" alt="グラフ2">
      </p>

      <h2>世界のウイスキー・日本のウイスキー</h2>
      <p>
        スコットランド、アイルランド、アメリカ、カナダ、日本。<br>
        この5カ国が世界的なウイスキー生産国として知られ、「5大ウイスキー」と呼ばれます。<br>
        これらの国々は、技術、品質、生産量などあらゆる面で優れており、世界中のウイスキーファンを魅了し続けています。<br>

        <img src="images/md-img3.jpg" alt="グラフ3">

        日本のウイスキーの歴史は、1923年、サントリー創業者の鳥井信治郎が、京都郊外の山崎の地に、我が国初のウイスキー蒸溜所建設に着手した年 に始まります。その後、長い年月をかけて、原酒の改良とブレンドを重ね、今ではジャパニーズウイスキーとして世界で認められるまでになりました。
      </p>
    </div>
    <div class="center">
      <button id="modalClose">閉じる</button>
    </div>
  </div>
</div>

<h2 class="page-title">ウイスキーとは？</h2>

<div class="ex-wrap">
  <p class="explanation">
    ウイスキーには様々な種類があり、国によって定義は異なっています。<br>
    一般的には「穀類を原料として、糖化、発酵の後に蒸留を行い、<br>
    木製の樽で貯蔵熟成させてできるお酒」をウイスキーと呼んでいます。<br>
    各国のウイスキーにはそれぞれ違った魅力があるので、紹介します。<br>
  </p>
</div>

<div class="center">
  <button id="detailView"><a class="inline" href="#inline">もっと詳しく <i class="fas fa-chevron-right"></i></a></button>
</div>

<section class="whisky-introduce">
  <h3 class="section-title">おすすめのウイスキーを紹介</h3>

  <div class="flexbox">
    <div class="item">
      <div class="wh-logo">
        <img src="images/wh-logo1.png" alt="スコッチウイスキー">
      </div>
      <h4>スコッチウイスキー</h4>
      <p>
        麦芽に「スモーキーフレーバー」と呼ばれる香りがついているのが特徴。
      </p>
    </div>

    <div class="item">
      <div class="wh-logo">
        <img src="images/wh-logo2.png" alt="アメリカンウイスキー">
      </div>
      <h4>アメリカンウイスキー</h4>
      <p>
        夏の暑さと冬の厳しい寒さに育まれた独特の甘味を持っている。
      </p>
    </div>

    <div class="item">
      <div class="wh-logo">
        <img src="images/wh-logo3.png" alt="ジャパニーズウイスキー">
      </div>
      <h4>ジャパニーズウイスキー</h4>
      <p>
        豊かな自然環境のなかで造り上げられた原酒の多彩さが特徴。
      </p>
    </div>
  </div>
</section>

<section class="whisky-search">
  <h3 class="section-title">自分に合うウイスキーを探そう</h3>

  <div class="center">
    <button id="whiskySearch">ウイスキーを探す <i class="fas fa-search"></i></button>
  </div>
</section>

<?php
$url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"]."/".basename(dirname(__DIR__)))."/";
?>

<script>
  let window_width = $(window).width();
  let modaalWidth = window_width * 0.7;
  if (window_width <= 500) {
    modaalWidth = window_width * 0.8;
  }

  $(".inline").modaal({
    background_scroll: 'true',
    width: modaalWidth,
  });

  $("#modalClose").on("click", function () {
    $(".inline").modaal("close");
  });

  $("#whiskySearch").on("click", function () {
    location.href = "<?php echo $url ?>?page=search";
  });
</script>
