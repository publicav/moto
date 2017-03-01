<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="img/web/count1.png">
    <link rel="stylesheet" href="css/adm.css">
    <title><?=$this->_title?></title>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/main.js"></script>
    <script src="js/ui/minified/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/adm.css">
    <?= $this->getCSSHTML()?>
    <?=$this->getJsHTML()?>
</head>

<body>
<?php include $tplName; ?>
</body>
</html>
