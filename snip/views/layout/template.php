<?php

/**
 * @type SLayout $this
 * @type string $url
 */

$url = $this->value('url');

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document Task</title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?=$url?>public/grid.css">
    <link rel="stylesheet" href="<?=$url?>public/style.css">

    <link rel="stylesheet" href="<?=$url?>public/fontello/css/fontello.css">
    <link rel="stylesheet" href="<?=$url?>public/fontello/css/animation.css">

    <script type="application/javascript" src="<?=$url?>public/js.libs/ns.application.js"></script>
    <script type="application/javascript" src="<?=$url?>public/js.app/init.js"></script>

</head>
<body>

<div id="page">
    <div id="info_panel">
        <div class="tbl">
            <div id="info_panel_title" class="tbl_cell">System Message</div>
            <div id="info_panel_close" class="tbl_cell width_5 text_right"><i class=" icon-cancel"></i></div>
        </div>
        <div id="info_panel_content"></div>
    </div>
    <div id="navigation">
        <?php SLayout::outPosition('navigation')?>
    </div>
    <div id="header">
        <?php SLayout::outPosition('header')?>
    </div>
    <div id="container" class="tbl">
        <div id="sidebar" class="tbl_cell valign_top width_20">
            <?php SLayout::outPosition('sidebar')?>
        </div>
        <div id="content" class="tbl_cell valign_top">
            <?php SLayout::outPosition('content')?>
        </div>
    </div>
    <div id="footer">footer</div>
</div>

</body>
</html>