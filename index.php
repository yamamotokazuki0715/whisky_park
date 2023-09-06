<?php
$page = "top";
if(isset($_GET["page"])){
  $page = $_GET["page"];
}
?>

<!DOCTYPE html>

<html lang="ja">

  <head>

    <meta charset="utf-8">

    <title>WHISKY PARK</title>

    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/common.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/f618628a74.js" crossorigin="anonymous"></script>

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- modaal -->
    <script src="js/modaal.js"></script>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

  </head>

  <body>
    <?php require_once __DIR__."/header.php"; ?>

    <div class="mainvisual">
      <img src="images/mainvisual.png" alt="メインビジュアル">
    </div>

    <div class="content"></div>

    <?php require_once __DIR__."/footer.php"; ?>

    <script src="js/common.js"></script>
    <script src="js/drawer.js"></script>
  </body>

</html>
