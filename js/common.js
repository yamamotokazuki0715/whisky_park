const getParam = function (name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

const setPage = function (id) {
  $(".mainvisual").css({
    display: "none"
  });
  $(".content").empty();

  $.ajax({
    url: `views/${id}.php`,
    type: "GET",
    success: function (response) {
      if (id === "top") {
        $(".mainvisual").css({
          display: "block"
        });
        $(".mainvisual").hide().fadeIn(150);
      }
      $(".content").html(response).hide().fadeIn(150);
    }
  });
};

$(document).ready(function () {
  if (!(getParam("page"))) {
    setPage("top");
  } else {
    const pageList = $(".page-change");
    for (const page of pageList) {
      if ($(page).attr("page") === getParam("page")) {
        if (getParam("word")) {
          $(".mainvisual").css({
            display: "none"
          });
          $(".content").empty();

          $.ajax({
            url: `views/search.php?word=${getParam("word")}`,
            type: "GET",
            success: function (response) {
              $(".content").html(response).hide().fadeIn(150);
            }
          });
          return;
        }
        setPage(getParam("page"));
        return;
      }
    }
    $(".mainvisual").css({
      display: "none"
    });
    $(".content").append($("<h2>").addClass("page-title").html(
      "お探しのページは見つかりませんでした。"
    ));
  }
});
