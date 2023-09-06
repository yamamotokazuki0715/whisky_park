<?php
  $whiskyData = [];
  if (isset($_POST["type"])) {
    $type = $_POST["type"];
    $sqlite = new SQLite3("whisky.db");
    $result = $sqlite->query("select * from t_whisky where f_whiskyType = '{$type}' order by random()");
    while ($data = $result->fetchArray(SQLITE3_ASSOC)) {
      $whiskyData[] = [
        "id" => $data["f_id"],
        "name" => $data["f_name"],
        "type" => $data["f_whiskyType"],
      ];
    }
    echo json_encode($whiskyData);
  } else {
    echo "<font color='red'>不正なアクセスです</font>";
  }
?>
