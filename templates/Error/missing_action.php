<?php
/**
 * @var string $class   呼び出し元コントローラの完全クラス名
 * @var string $method  参照しようとしたアクション名
 */
?>
<h1>Missing Action</h1>
<p>
  Controller <strong><?= h($class) ?></strong>  
  does not have an action named  
  <strong><?= h($method) ?></strong>.
</p>
