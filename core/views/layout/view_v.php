<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/view.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/web/count1.png">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="level">
    <meta name="description" content="<?= $this->_MetaD ?>">
    <meta name="keywords" content="<?= $this->_MetaK ?>">
    <title><?= $this->_title ?></title>
    <script src="js/jquery-2.2.4.min.js"></script>
    <?= $this->getCSSHTML() ?>
    <?= $this->getJsHTML() ?>
</head>
<script type="text/javascript">
    <?php  //include __DIR__ . "/../base/jquery_exec.php"; ?>
</script>


<body>
<?php include $tplName; ?>
</body>
</html>
