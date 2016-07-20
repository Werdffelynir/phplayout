<?php
/**
 * @type SLayout $this
 * @var $items
 */

$items = isset($items) && is_array($items) ? $items : [];

?>

<ul>
    <?php foreach($items as $item): ?>
        <li>
            <a href="/s/<?php echo $item['link'] ?>"><?php echo $item['title'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>
