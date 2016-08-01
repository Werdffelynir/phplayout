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

    <!--   solarized_dark.css color-brewer.css idea.css   -->
    <link rel="stylesheet" href="<?=$url?>public/highlight/styles/idea.css">
    <script src="<?=$url?>public/highlight/highlight.pack.js"></script>


    <script></script>

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
    <div id="header" class="color_bg_header">
        <?php SLayout::outPosition('header')?>
    </div>

    <?php if(empty(SLayout::outPosition('sidebar', true))): ?>

        <div id="container">
            <div id="content">
                <?php SLayout::outPosition('content')?>
            </div>
        </div>

    <?php else: ?>

        <div id="container" class="grid clear">
            <div id="sidebar" class="grid3 first">
                <?php SLayout::outPosition('sidebar')?>
            </div>
            <div id="content" class="grid9">
                <?php SLayout::outPosition('content')?>
            </div>
        </div>

    <?php endif; ?>

    <div id="footer">
        <div class="copy_org">open Web Code</div>
    </div>
<!--    <div class="logo"><i>psycho</i><i>Sun</i><i>Light</i><i>System</i></div>-->
</div>


</body>
</html>