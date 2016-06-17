<?php
isset($title) OR $title = 'Default Title';
isset($content) OR $content = 'Default Content Text';
?>
<div class="article">

    <h2><?=$title?></h2>
    <div><?=$content?></div>

</div>

<?php SLayout::outPosition('banner')?>