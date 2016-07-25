<?php
/**
 * @type SLayout $this
 * @var $item
 * @var $items
 */


$is_admin = $this->Controller->isAdmin;


?>

<div class="item">

    <div class="item_info tbl">
        <div class="tbl_cell">
            <?='Create: '.date("d.m.y",strtotime($item['created']))?>
            <?='Update: '.date("d.m.y",strtotime($item['updated']))?>
        </div>
        <div class="tbl_cell text_right"><?=$item['tags']?></div>
    </div>

    <h1 class="item_title"><?=$item['title']?></h1>

    <div class="item_content">
        <?php echo Parsedown::instance()->text($item['content'])?>
    </div>

</div>

