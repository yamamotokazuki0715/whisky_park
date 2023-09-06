<?php
  $jsonData = [];
  $tagList = [];

  if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $sqlite = new SQLite3("whisky.db");

    $t_whiskyQuery = "select * from t_detail inner join t_whisky on t_detail.f_id = t_whisky.f_id where t_whisky.f_id = {$id}";
    $t_whiskyResult = $sqlite->query($t_whiskyQuery);

    $t_tagQuery = "select * from t_tag where f_id = {$id}";
    $t_tagResult = $sqlite->query($t_tagQuery);

    $t_whiskyData = $t_whiskyResult->fetchArray(SQLITE3_ASSOC);

    while ($t_tagData = $t_tagResult->fetchArray(SQLITE3_ASSOC)) {
      $tagList[] = $t_tagData["f_tag"];
    }

    $jsonData = [
      "id" => $t_whiskyData["f_id"],
      "name" => $t_whiskyData["f_name"],
      "type" => $t_whiskyData["f_whiskyType"],
      "desc" => $t_whiskyData["f_desc"],
      "info" => $t_whiskyData["f_info"],
      "tagList" => $tagList,
    ];

    echo json_encode($jsonData);
  } else {
    echo "<font color='red'>不正なアクセスです</font>";
  }
?>
