<?php

include 'GridGenerator.php';

$storage = [
    'css' => false,
    'link' => false,
];

if(!empty($_POST['width'])){

    $codeBefore = file_get_contents('part.reset.css');
    $codeAfter = file_get_contents('part.build.css');

    $data = [
        'width'     => !empty($_POST['width']) ? $_POST['width'] : 1000,
        'padding'   => !empty($_POST['padding']) ? $_POST['padding'] : 2,
        'grid'      => !empty($_POST['grid']) ? $_POST['grid'] : 12,
        'prefix'    => '.grid',
        'compress'  => !empty($_POST['compress']) ? true : false,
        'codeBefore'=> !empty($_POST['reset']) ? $codeBefore : '',
        'codeAfter' => !empty($_POST['helpers']) ? $codeAfter : '',
    ];

    $generator = new GridGenerator($data);
    $storage['css'] = $generator->saveCss(null, true);
    echo json_encode($storage);
    exit();
}

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <?php if($storage['css']):?> <?php endif;?>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/highlight.js/9.2.0/styles/default.min.css">
    <script src="//cdn.jsdelivr.net/highlight.js/9.2.0/highlight.min.js"></script>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<div id="page">
    <div id="header">
        <div class="tbl">
            <div class="tbl_cell"><div class="logo">CSS Grid Generator</div></div>
            <div class="tbl_cell"></div>
        </div>
    </div>
    <div class="tbl">
        <div class="tbl_cell valign_top sidebar">

            <form name="genform" action="/jopa" method="post">
                <div class="tbl">
                    <div class="tbl_cell label">Width</div>
                    <div class="tbl_cell"><input name="width" type="number" value="960"></div>
                </div>
                <div class="tbl">
                    <div class="tbl_cell label">Padding</div>
                    <div class="tbl_cell"><input name="padding" type="number" value="2"></div>
                </div>
                <div class="tbl">
                    <div class="tbl_cell label">Columns</div>
                    <div class="tbl_cell"><input name="grid" type="number" value="12"></div>
                </div>
                <div class="tbl">
                    <div class="tbl_cell label">Compressed file</div>
                    <div class="tbl_cell"><input name="compress" type="checkbox"></div>
                </div>
                <div class="tbl">
                    <div class="tbl_cell label">Add reset style</div>
                    <div class="tbl_cell"><input name="reset" type="checkbox" checked="checked"></div>
                </div>
                <div class="tbl">
                    <div class="tbl_cell label">Add helpers style</div>
                    <div class="tbl_cell"><input name="helpers" type="checkbox" checked="checked"></div>
                </div>

                <div class="txt_center">
                    <input type="submit" value="Create">
                </div>

            </form>

        </div>
        <div class="tbl_cell valign_top content">

            <div class="result" style="display: none">
                <h2>Сгенерирован: <sub class="css_link"></sub></h2>
                <pre class="code"><code class="css"></code></pre>
            </div>

        </div>
    </div>
    <div id="footer">Copyright © 2013-<?=date('Y')?> by OL Werdffelynir w-code.ru. All rights reserved.</div>
</div>


<script>

    var o = {};
    o.content = document.querySelector('.content');
    o.contentWidth = o.content.clientWidth;
    o.result = document.querySelector('.result');
    o.cssWrap = document.querySelector('.content .code');
    o.cssEntry = document.querySelector('.content .css');
    o.cssLink = document.querySelector('.content .css_link');
    o.form = document.forms.genform;
    o.form.onsubmit = function(event){
        o.result.style['display'] = 'none';
        event.preventDefault();
        request(o.form);
    };

    function request(form){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '');
        xhr.onreadystatechange = function(event){
            if(xhr.status == 200 && xhr.readyState == 4){
                try {
                    var storage = JSON.parse(xhr.responseText),
                        linkData = "data:application/octet-stream;charset=utf-8," + encodeURIComponent(storage['css']);

                    o.result.style['display'] = 'block';
                    o.cssEntry.innerHTML = storage['css'];
                    o.cssLink.innerHTML = '<a href="'+linkData+'" target="_blank" download="grid.css">grid.css</a>';

                    hljs.configure({useBR: false});
                    hljs.highlightBlock(o.cssEntry);

                    o.cssWrap.style.width = (o.contentWidth - 10) + "px";
                }catch(e){}
            }
        };
        xhr.send(new FormData(form));
    }

    function download(filename, text) {
        var pom = document.createElement('a');
        //pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        pom.setAttribute('href', 'data:application/octet-stream;charset=utf-8,' + encodeURIComponent(text));
        pom.setAttribute('download', filename);

        if (document.createEvent) {
            var event = document.createEvent('MouseEvents');
            event.initEvent('click', true, true);
            pom.dispatchEvent(event);
        }
        else {
            pom.click();
        }
    }

</script>
</body>
</html>