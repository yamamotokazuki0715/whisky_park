<?php
  $whiskyData = [];
  if (isset($_POST["word"])) {
    $word = $_POST["word"];
    $sqlite = new SQLite3("whisky.db");
    $count = $sqlite->query("select count(*) from t_tag where f_tag like '{$word}%'");
    $countFlg = $count->fetchArray(SQLITE3_ASSOC);
    if ($countFlg["count(*)"] === 0) {
      echo json_encode([
        "result" => "none"
      ]);
      exit();
    } else if ($countFlg["count(*)"] > 0) {
      $result = $sqlite->query("select * from t_whisky inner join t_tag on t_whisky.f_id = t_tag.f_id where t_tag.f_tag like '{$word}%' order by random()");
      while ($data = $result->fetchArray(SQLITE3_ASSOC)) {
        $tagList = [];
        $tagData = $sqlite->query("select * from t_tag where f_id = {$data["f_id"]}");
        while ($tag = $tagData->fetchArray(SQLITE3_ASSOC)) {
          $tagList[] = $tag["f_tag"];
        }
        $whiskyData[] = [
          "id" => $data["f_id"],
          "name" => $data["f_name"],
          "type" => $data["f_whiskyType"],
          "tagList" => $tagList,
        ];
      }
      echo json_encode([
        "result" => "success",
        "data" => $whiskyData,
      ]);
      exit();
    } else {
      echo json_encode([
        "result" => "error"
      ]);
      exit();
    }
  } else {
    echo "<font color='red'>不正なアクセスです</font>";
    exit();
  }
?>
