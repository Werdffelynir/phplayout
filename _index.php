<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site: snip.loc</title>
    <style>
        *{margin: 0; padding: 0; box-sizing: border-box;}
        html, body{ font-family: "Ubuntu Condensed", Arial, Sans; background-color: #2D2D27;}
        #page{ width: 80%; margin: 0 auto; }
        #header{ padding: 10px;background-color: #622c2c;color: #d27979; }
        #content{ padding: 10px; background-color: #967979; color: #000; min-height: 300px; }
        #footer{ padding: 10px;background-color: #622c2c;color: #d27979;font-size: 12px; }
        pre { background-color: rgb(33, 31, 18);color: rgb(191, 210, 4);padding: 10px; }
    </style>
</head>
<body>

<div id="page">
    <div id="header">
        <h1>Site created on host: snip.loc</h1>
    </div>
    <div id="content">
        <p>Path to site files:</p>
        <pre>/var/www/snip.loc/index.html</pre>

        <br>

        <p>Path to apache config:</p>
        <pre>/etc/apache2/sites-available/snip.loc.conf</pre>

        <br>

        <p>Config for <code>.htaccess</code>:</p>
        <pre>
&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On

    #RewriteBase /

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php [QSA,L]
&lt;/IfModule&gt;</pre>

        <br>

        <p>Commands:</p>
        <pre>sudo gedit /etc/apache2/sites-available/snip.loc.conf</pre>
        <pre>sudo gedit /etc/php5/apache2/php.ini</pre>
        <pre>sudo /etc/init.d/apache2 restart</pre>

    </div>
    <div id="footer">
        <p>Powered by SAPI generator. Complete 07.08.2016 01:49</p>
    </div>
</div>

</body>
</html>