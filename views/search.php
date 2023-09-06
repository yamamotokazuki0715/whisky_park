<?php
$word = (isset($_GET["word"])) ? $_GET["word"] : "";

$sqlite = new SQLite3("../whisky.db");
$count = $sqlite->query("select count(*) from t_tag where f_tag like '{$word}%'");
$countFlg = $count->fetchArray(SQLITE3_ASSOC);
?>

<div id="inline">
  <h2 id="whName"></h2>

  <div class="modal-wrap">
    <div class="modal-l">
      <img id="modalImg">
    </div>

    <div class="modal-r">
      <p id="whDesc"></p>

      <div class="tag-area"></div>

      <div class="info-area">
        <p id="whInfo"></p>
      </div>
    </div>
  </div>
</div>


<h2 class="page-title">ウイスキーを探す</h2>

<div class="ex-wrap">
  <p class="explanation">
    ここでは、タグでウイスキーを検索できます。<br>
    ウイスキーごとに「#甘い」「#芳醇」などのタグがついていますので、<br>
    自分に合ったウイスキーを探してみましょう。<br>
    文字を入力すると、下に入力候補が出てきます。<br>
    (※ウイスキーの画像をクリックすると、ポップアップが表示されます)<br>
  </p>
</div>

<div class="search-area">
  <div class="input-area">
    <input type="text" id="searchWord" placeholder="例 : 甘い" value="<?php echo $word ?>"><!--
    --><button id="searchButton">検索</button>
  </div>

  <div class="flexbox">
    <?php if ($word !== ""): ?>
      <?php if ($countFlg["count(*)"] === 0): ?>
        <h4 class="result-msg">「<?php echo $word ?>」に関連するタグは見つかりませんでした。</h4>
      <?php elseif ($countFlg["count(*)"] > 0): ?>
        <?php
          $result = $sqlite->query("select * from t_whisky inner join t_tag on t_whisky.f_id = t_tag.f_id where t_tag.f_tag like '{$word}%' order by random()");
          while($whiskyInfo = $result->fetchArray(SQLITE3_ASSOC)):
        ?>
        <div class="item">
          <a href="#inline" class="inline" id="<?php echo $whiskyInfo["f_id"] ?>">
            <div class="wh-img">
              <img src="images/<?php echo $whiskyInfo["f_id"] ?>.jpg" alt="<?php echo $whiskyInfo["f_name"] ?>">
            </div>
          </a>
          <h4><?php echo $whiskyInfo["f_name"] ?></h4>
          <div class="wh-tag-area">
            <?php
            $tagData = $sqlite->query("select * from t_tag where f_id = {$whiskyInfo["f_id"]}");

            while ($tag = $tagData->fetchArray(SQLITE3_ASSOC)) {
              if ($tag["f_tag"] === $word) {
                echo "<span class='match'>#{$tag["f_tag"]}</span>";
              } else {
                echo "<span>#{$tag["f_tag"]}</span>";
              }
            }
            ?>
          </div>
        </div>
        <?php endwhile; ?>
      <?php else: ?>
        <h4 class="result-msg">エラーが起きました。もう一度お試しください。</h4>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

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

  $(".inline").on("click", function () {
     modalOpen($(this).attr("id"));
  });

  $("span").on("click", function () {
    $(".inline").modaal("close");
    $("#searchWord").val($(this).html().replace("#", ""));
    searchWhisky($(this).html().replace("#", ""));
  });

  // モーダルを開く
  const modalOpen = function (id) {
    $.ajax({
      url: "getModalData.php",
      type: "POST",
      data: {
        id: id,
      },
      dataType: "json",
      success: function (whiskyData) {
        $("#whName").html(`${whiskyData.name} | ${whiskyData.type}`);
        $("#modalImg").attr("src", `images/${whiskyData.id}.jpg`).attr("alt", whiskyData.name);
        $("#whDesc").html(whiskyData.desc);
        $("#whInfo").html(whiskyData.info);

        const tagList = whiskyData.tagList;

        $(".tag-area").empty();

        for (const tag of tagList) {
          const span = $("<span>").html(`#${tag}`).on("click", function () {
            $(".inline").modaal("close");
            $("#searchWord").val($(this).html().replace("#", ""));
            searchWhisky($(this).html().replace("#", ""));
          });
          $(".tag-area").append(span);
        }
      }
    });
  };

  const searchWhisky = function (word) {
    $.ajax({
      url: "getSearchData.php",
      type: "POST",
      data: {
        word: word,
      },
      dataType: "json",
      success: function (res) {
        $(".flexbox").empty();
        if (res.result === "success") {
          for (const whisky of res.data) {
            const item = $("<div>").addClass("item");
            const whImg = $("<div>").addClass("wh-img");
            const inline = $("<a>").attr("href", "#inline").attr("id", whisky.id).addClass("inline").on("click", function () {
              modalOpen(whisky.id);
            }).modaal({
              background_scroll: 'true',
              width: modaalWidth,
            });
            const img = $("<img>").attr("src", `images/${whisky.id}.jpg`).attr("alt", whisky.name);
            const h4 = $("<h4>").html(whisky.name);
            const tagArea = $("<div>").addClass("wh-tag-area");

            for (const tag of whisky.tagList) {
              const span = $("<span>").html(`#${tag}`).on("click", function () {
                $("#searchWord").val($(this).html().replace("#", ""));
                searchWhisky($(this).html().replace("#", ""));
              });
              if (tag.match(word)) {
                span.addClass("match");
              }
              tagArea.append(span);
            }

            whImg.append(img);
            inline.append(whImg);
            item.append(inline, h4, tagArea);
            $(".flexbox").append(item);
          }
        } else if (res.result === "none") {
          const resultMsg = $("<h4>").html(`「${word}」に関連するタグは見つかりませんでした。`).addClass("result-msg");
          $(".flexbox").append(resultMsg);
        } else if (res.result === "error") {
          const resultMsg = $("<h4>").html(`エラーが起きました。もう一度お試しください。`).addClass("result-msg");
          $(".flexbox").append(resultMsg);
        }
      },
      error: function (err) {
        console.error(err);
      }
    });
  };

  $("#searchWord").autocomplete({
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

  $("#searchWord").on("keydown", function (e) {
    if (e.key === "Enter") {
      if (!($("#searchWord").val())) return;
      searchWhisky($(this).val());
    }
  });

  $("#searchButton").on("click", function () {
    if (!($("#searchWord").val())) return;
    searchWhisky($("#searchWord").val());
  });

</script>
