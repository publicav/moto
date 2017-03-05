<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/adm.css">
    <link type="text/css" rel="stylesheet" href="css/left-menu.css">
    <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/web/count1.png">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="level">
    <meta name="description" content="<?= $this->_MetaD ?>">
    <meta name="keywords" content="<?= $this->_MetaK ?>">
    <title><?= $this->_title ?></title>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script charset="utf-8" src="js/main.js"></script>
    <script src="js/jquery.colorbox-min.js"></script>
    <link rel="stylesheet" href="css/cb.css"/>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="js/ui/minified/jquery-ui.min.js"></script>
    <script src="js/left-menu.js"></script>
    <script src="js/login.js"></script>

    <?= $this->getCSSHTML() ?>
    <?= $this->getJsHTML() ?>
</head>
<script type="text/javascript">
    <?php  include __DIR__ . "/../base/jquery_exec.php"; ?>
</script>


<body>
<?php include $tplName; ?>
</body>
</html>
