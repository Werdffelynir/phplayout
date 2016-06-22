<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="public/grid.css">
    <link rel="stylesheet" href="public/style.css">
    <script src="../../../task/public/application.js"></script>
</head>
<body>

<div id="page">

    <div id="header">
        <?php SLayout::outPosition('header')?>
    </div>

    <div class="tbl">
        <div id="navigation" class="tbl_cell valign_top width_25">
            <?php SLayout::outPosition('navigation')?>
        </div>
        <div id="content"  class="tbl_cell valign_top">
            <?php SLayout::outPosition('content')?>
        </div>
    </div>

    <div id="footer">
        <?php SLayout::outPosition('footer')?>
        <?php echo $this->value('banner2')?>
    </div>

</div>

</body>
</html>

