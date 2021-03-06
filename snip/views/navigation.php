<?php

/**
 * @type SLayout $this
 * @type string $url
 * @type array $categories
 */

$url = '/q/';

?>

<div class="tbl">
    <div class="tbl_cell">
        <ul>
            <?php
            foreach($categories as $cat):
                echo '<li><a href="'.$url.$cat['link'].'">'.$cat['title'].'</a></li>';
            endforeach;
            ?>
        </ul>
    </div>
    <div class="tbl_cell nav_right text_right">
        <a href="/runjs" class="btn_inline_orange">RunJS</a>
        <a href="/cssgrid" class="btn_inline_orange">GridCSS</a>
    </div>
</div>
