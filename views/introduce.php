<?php
$url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"]."/".basename(dirname(__DIR__)))."/";

$sqlite = new SQLite3("../whisky.db");
$result = $sqlite->query("select * from t_whisky where f_whiskyType = 'スコッチ' order by random()");
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

<h2 class="page-title">ウイスキー紹介</h2>

<div class="ex-wrap">
  <p class="explanation">
    ここでは、スコッチウイスキー、アメリカンウイスキー、<br>
    ジャパニーズウイスキーについて代表的なものを紹介します。<br>
    まだウイスキーを飲んだことのない人や、<br>
    最近ウイスキーに興味を持ち始めた初心者さんでも<br>
    飲みやすいものを紹介しますので、是非ともご覧ください。<br>
    (※ウイスキーの画像をクリックすると、ポップアップが表示されます)
  </p>
</div>

<div class="tab-area-wrap">
  <button id="scotch" class="selected">スコッチ</button><!--
  --><button id="american">アメリカン</button><!--
  --><button id="japanese">ジャパニーズ</button>

  <div class="tab-area">
    <div class="flex-wrap">
      <div class="flexbox">
        <?php while($whiskyInfo = $result->fetchArray(SQLITE3_ASSOC)): ?>
        <div class="item">
          <a href="#inline" class="inline" id="<?php echo $whiskyInfo["f_id"] ?>">
            <div class="wh-img">
              <img src="images/<?php echo $whiskyInfo["f_id"] ?>.jpg" alt="<?php echo $whiskyInfo["f_name"] ?>">
            </div>
          </a>
          <h4><?php echo $whiskyInfo["f_name"] ?></h4>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
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
            location.href=`<?php echo $url; ?>?page=search&word=${tag}`;
          });
          $(".tag-area").append(span);
        }
      }
    });
  };

  $("button").on("click", function () {
    if (($(this).attr("class") === "selected")) return;

    $("button").removeClass("selected");
    $(this).addClass("selected");

    $(".tab-area").css({
      borderColor: $(this).css("background-color"),
    });

    $(".flexbox").empty();

    $.ajax({
      url: "./getWhiskyData.php",
      type: "POST",
      data: {
        type: $(this).html(),
      },
      dataType: "json",
      success: function (response) {
        for (const whisky of response) {
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

          whImg.append(img);
          inline.append(whImg);
          item.append(inline, h4);
          $(".flexbox").append(item);
        }
      },
    });
  });

  $(".inline").on("click", function () {
     modalOpen($(this).attr("id"));
  });
</script>
