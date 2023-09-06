<?php
$db = new SQLite3("whisky.db");

// $db->query("insert into t_whisky(f_name, f_whiskyType) values('余市', 'ジャパニーズ')");

// $db->query("delete from user2 where name = 'furuta'");

// $sql = "select * from sqlite_master where type = 'table'";

// $sql = "select * from t_whisky where f_whiskyType = 'スコッチ' order by random()";

// $sql = "select * from t_detail inner join t_whisky on t_detail.f_id = t_whisky.f_id where t_whisky.f_id = 1";

// $sql = "select * from t_tag group by f_tag";

// $sql = "select * from t_tag where f_tag like '%甘い%'";

// $sql = "select * from t_tag where f_tag like '甘%' order by random()"; これ使う

// $sql = "select count(*) from t_tag where f_tag like 'い%' order by random()";

$sql = "select * from t_tag where f_tag like '甘い%' order by random()";

$sql = "select * from t_whisky inner join t_tag on t_whisky.f_id = t_tag.f_id where t_tag.f_tag like '甘い%' order by random()";

$result = $db->query($sql);

echo "<br><br>";

while($res = $result->fetchArray(SQLITE3_ASSOC)){
  // print_r($res);
  var_dump($res);
  echo "<br><br>";
}

$db->close();
?>
