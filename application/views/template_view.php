<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 9:59
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="images/panda_icon.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Cloud Panda</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

    <script src="plugins/ckeditor/ckeditor.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/fonts.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<div id="page" class="container">
    <div id="header">
        <div id="logo">
            <a href="/"><img src="images/panda_main.jpg" alt="" /></a>
        </div>
        <div id="menu">
            <ul>
                <?php include 'application/views/menu/'.$content_view; ?>
            </ul>
        </div>
    </div>
    <div id="main">
        <div id="welcome">
            <div class="title">
                <h2>Cloud Panda</h2>
                <span class="byline">User friendly site for managing articles</span>
            </div>
        </div>
            <?php include 'application/views/content/'.$content_view; ?>
        <div id="copyright">
            <span>&copy; All rights reserved</span>
        </div>
    </div>
</div>
</body>
</html>