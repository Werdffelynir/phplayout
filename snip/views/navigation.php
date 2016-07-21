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
            <?php foreach($categories as $cat):?>
                <li><a href="<?php echo $url . $cat['link']?>"><?php echo $cat['title']?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="tbl_cell nav_right text_right">
        <a href="<?=$url?>editor" class="btn_inline_orange">JS Run</a>
        <a href="<?=$url?>editor" class="btn_inline_orange">GridCSS</a>
    </div>
</div>




