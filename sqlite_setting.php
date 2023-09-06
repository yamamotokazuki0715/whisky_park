<?php
$db = new SQLite3("whisky.db");

// $db->query("create table t_whisky(f_id integer primary key autoincrement, f_name text, f_whiskyType text)");
//
// $db->query("create table t_tag(f_id integer, f_tag text)");
//
$db->query("create table t_detail(f_id integer, f_desc text, f_info text)");

$db->close();
?>
