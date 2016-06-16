<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        *{margin: 0; padding: 0;}
        html,body{
            background-color: #000;
            color: #e8e8e8;
            font-size: 90%;
        }
        ul, li, ol{margin: 0; padding: 0;}
        a{color: #bba2ff;}
        a:hover{color: #d6c8ff;}
        #page{
            background-color: #2b2b2b;
            width: 800px;
            margin: 0 auto;
        }
        #header{
            line-height: 30px;
            text-align: center;
            color: #efdb22;
            background-color: #212121;
        }
        #navigation{
            border-right: 4px solid #212121;
        }
        #navigation ul{
            min-height: 600px;
        }
        #navigation li{
            list-style: none;
        }
        #navigation li a:hover{
            background-color: #131313;
        }
        #navigation li a{
            display: block;
            line-height: 30px;
            text-align: center;
            text-decoration: none;
        }
        #content{}
        #footer{}
    </style>
</head>
<body>

<div id="page">

    <div id="header">
        <?php Layout::output('header')?>
    </div>

    <div style="display: table">
        <div id="navigation" style="display: table-cell; width: 20%">

                <?php Layout::output('navigation')?>

        </div>
        <div id="content" style="display: table-cell">

                <?php Layout::output('content')?>

        </div>
    </div>

    <div id="footer">
        <?php Layout::output('footer')?>
    </div>

</div>

</body>
</html>