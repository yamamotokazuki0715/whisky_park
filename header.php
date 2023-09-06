<?php
$navList = [
  "top" => "ウイスキーとは？",
  "introduce" => "ウイスキー紹介",
  "search" => "探す",
  "help" => "お問い合わせ",
];

$url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);

$url = explode("?", $url);

$word = "";
if (isset($_GET["word"])) {
  $word = $_GET["word"];
}
?>

<header>
  <div class="header-left">
    <h1><a class='page-change' id='top'><img src="./images/sitelogo.png" alt="サイトロゴ"></a></h1>
  </div>

  <div class="header-right">
    <div class="search">
      <input type="text" id="search" placeholder="検索 &#xf002;">
    </div>
    <nav class="pc-nav">
      <ul>
        <?php foreach ($navList as $pageName => $index) : ?>
          <li>
            <?php echo "<a class='page-change' page='{$pageName}' href=\"{$url[0]}?page={$pageName}\">{$index}</a>"; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <!-- ハンバーガーメニュー -->
    <div id="nav-toggle">
      <div>
          <span></span>
          <span></span>
          <span></span>
      </div>
    </div>

    <div id="drawer-nav">
      <nav>
        <!-- <input type="text" id="search" placeholder="検索 &#xf002;"> -->
        <ul>
          <?php foreach ($navList as $pageName => $index) : ?>
            <li>
              <?php echo "<a class='page-change' page='{$pageName}' href=\"{$url[0]}?page={$pageName}\">{$index}</a>"; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </nav>
    </div>
  </div>
</header>

<script>
  const tagList = [];
  const readList = [];

  <?php
  $db = new SQLite3("./whisky.db");
  $sql = "select * from t_tag group by f_tag";
  $result = $db->query($sql);
  while ($tagInfo = $result->fetchArray(SQLITE3_ASSOC)) {
    echo "tagList.push(\"{$tagInfo["f_tag"]}\");";
  }
  ?>

  for (let i = 0; i < tagList.length; i++) {
    $.ajax({
      url: "https://labs.goo.ne.jp/api/hiragana",
      type: "POST",
      data: {
        app_id: "0222b0ae03e178dfcd2d1899422dab02bea0a8c3c26aeb46de629016915424fb",
        sentence: tagList[i],
        output_type: "hiragana"
      },
      success: function (res) {
        readList.push([
          tagList[i], res.converted
        ]);
      }
    });
  }

  $("#search").autocomplete({
    source: function(request, response){
      var suggests = [];
      var regexp = new RegExp('(' + request.term + ')');

      $.each(readList, function(i, values){
        if(values[0].match(regexp) || values[1].match(regexp)){
          suggests.push(values[0]);
        }
      });

      response(suggests);
    },
    autoFocus: true,
    delay: 100,
    minLength: 1
  });

  $("#search").on("keydown", function (e) {
    if (e.key === "Enter") {
      const word = $(this).val();
      if (!(word)) return;
      $(this).val("");
      location.href=`<?php echo $url[0]; ?>?page=search&word=${word}`;
    }
  });
</script>
