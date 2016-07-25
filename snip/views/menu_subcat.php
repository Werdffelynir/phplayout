<?php
/**
 * @type SLayout $this
 * @var $items
 */

$items = isset($items) && is_array($items) ? $items : [];

$uri = '/q/' . $this->value('currentActionCat') . '/';
?>

<ul>
    <?php foreach($items as $item): ?>
        <li>
            <a href="<?php echo $uri . $item['link'] ?>"><?php echo $item['title'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>
