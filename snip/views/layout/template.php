<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document Task</title>

    <link rel="stylesheet" href="public/grid.css">
    <link rel="stylesheet" href="public/style.css">

    <link rel="stylesheet" href="public/fontello/css/fontello.css">
    <link rel="stylesheet" href="public/fontello/css/animation.css">

    <script src="public/js.libs/ns.application.js" type="application/javascript"></script>
    <script src="public/js.app/init.js" type="application/javascript"></script>

    <style>
        .piece-box {
            position: absolute;
            background-color: #ffffff;
            box-shadow: 0 0 10px -3px #000;
        }
        .piece-title {
            display: inline-block;
        }
        .piece-content {

        }
        .piece-close {
            display: inline-block;
            position: absolute;
            right: 5px;
        }
    </style>
</head>
<body>


<div id="page">
    <div id="info_panel">
        <div class="tbl">
            <div id="info_panel_title" class="tbl_cell">System Message</div>
            <div id="info_panel_close" class="tbl_cell width_5 text_right"><i class=" icon-cancel"></i></div>
        </div>
        <div id="info_panel_content">

            <p>Lorem-ipsum dolor sit --amet, consectetur adipisicing elit. Alias amet architecto asperioresbus.</p>

        </div>
    </div>


    <div id="navigation">
        <ul>
            <li><a href="#link1">PHP</a></li>
            <li><a href="#link2">JavaScript</a></li>
            <li><a href="#link3">HTML/CSS</a></li>
            <li><a href="#link4">Server</a></li>
            <li><a href="#link5">Python</a></li>
            <li><a href="#link6">ActionScript</a></li>
            <li><a href="#link7">C#</a></li>
            <li><a href="#link8">Java</a></li>
            <li><a href="#link9">Linux</a></li>
            <li><a href="#link10">Private</a></li>
        </ul>
    </div>
    <div id="header">header</div>
    <div id="container" class="tbl">
        <div id="sidebar" class="tbl_cell valign_top width_20">
            <div>
                <ul>
                    <li><a href="#link1">PHP</a></li>
                    <li><a href="#link2">JavaScript</a></li>
                    <li><a href="#link3">HTML/CSS itaque itaquaque</a></li>
                    <li><a href="#link4">Server</a></li>
                    <li><a href="#link5">Python itaque</a></li>
                    <li><a href="#link6">ActionScript itaqueitaque</a></li>
                    <li><a href="#link7">C#</a></li>
                    <li><a href="#link8">Java</a></li>
                    <li><a href="#link9">Linux</a></li>
                    <li><a href="#link10">Private Javaffava Rcri Fptript</a></li>
                    <li><a href="#link1">PHP JavaScript</a></li>
                    <li><a href="#link2">JavaScript</a></li>
                    <li><a href="#link3">HTML/CSS</a></li>
                    <li><a href="#link4">ServerSerServerver</a></li>
                    <li><a href="#link5">Pythe Eee rvererver</a></li>
                    <li><a href="#link6">ActionScript itaque itaque</a></li>
                    <li><a href="#link7">C#</a></li>
                    <li><a href="#link8">Java</a></li>
                    <li><a href="#link9">Linux</a></li>
                    <li><a href="#link10">PrivatePrivatePrivate</a></li>
                    <li><a href="#link1">PHP</a></li>
                    <li><a href="#link2">JavaScript</a></li>
                    <li><a href="#link3">HTML/CSS Private Private</a></li>
                    <li><a href="#link4">Server</a></li>
                    <li><a href="#link5">Python</a></li>
                    <li><a href="#link6">ActionScript</a></li>
                    <li><a href="#link7">C#</a></li>
                    <li><a href="#link8">Java itaque itaque</a></li>
                    <li><a href="#link9">Linux itaque</a></li>
                    <li><a href="#link10">Private</a></li>
                </ul>
            </div>
        </div>
        <div id="content" class="tbl_cell valign_top">
            <?php SLayout::outPosition('editor')?>

        </div>
    </div>
    <div id="footer">footer</div>
</div>


</body>
</html>