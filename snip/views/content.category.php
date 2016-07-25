<?php
/**
 * @type SLayout $this
 * @var $items
 */


//var_dump($this);

$uri = '/q/' . $this->value('currentActionCat') . '/' . $this->value('currentActionSubcat') . '/';

?>

<div class="itemlist">

    <?php foreach($items as $item): ?>

            <div class="tbl itempreview">
                <div class="tbl_cell itempreview_title"><a href="<?php echo $uri . $item['link'] ?>"><?php echo $item['title'] ?></a></div>
                <div class="tbl_cell text_right width_10 itempreview_date"><?php echo date("d.m.Y", strtotime($item['created'])) ?></div>
                <div class="tbl_cell text_center width_4 itempreview_vote"><?php echo !empty($item['vote'])?$item['vote']:' + ' ?></div>
            </div>

    <?php endforeach; ?>

</div>




<?php
/*
array (size=3)
  0 =>
    array (size=10)
      'id' => string '15' (length=2)
      'deep' => string '2' (length=1)
      'link' => string 'ajax' (length=4)
      'title' => string 'subcat ajax XMLHttpRequest method use' (length=37)
      'content' => string 'ajax data' (length=9)
      'created' => string '09.07.2016 01:30:53' (length=19)
      'updated' => null
      'keyword' => string '' (length=0)
      'description' => string '' (length=0)
      'tags' => string '' (length=0)
  1 =>
*/
?>