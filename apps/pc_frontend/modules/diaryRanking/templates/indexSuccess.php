<?php use_helper('opDiary') ?>

<div class="parts">
<div class="partsHeading"><h3>日記アクセスランキング</h3></div>
<ol>
<?php foreach ($results as $result): ?>
  <li>
    <?php echo op_diary_link_to_show($result['diary']) ?>
    <?php echo $result['score'] ?>アクセス
  </li>
<?php endforeach ?>
</ol>
</div>
