<?php
// $title: 画面タイトル
?>
<style>
.mbs-header-bar {
    display: flex;
    border: 2px solid #222;
    border-bottom: none;
    width: 100%;
    height: 60px;
    align-items: center;
    font-size: 26px;
    font-family: 'MS UI Gothic', Arial, sans-serif;
    background: #fff;
    box-sizing: border-box;
}
.mbs-header-bar .mbs-logo {
    flex: 0 0 120px;
    text-align: center;
    font-weight: bold;
    border-right: 2px solid #222;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.mbs-header-bar .mbs-title {
    flex: 0 0 240px;
    text-align: center;
    border-right: 2px solid #222;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}
.mbs-header-bar .mbs-breadcrumb {
    flex: 1;
    padding-left: 16px;
    font-size: 20px;
    color: #222;
    display: flex;
    align-items: center;
}
</style>
<div class="mbs-header-bar">
    <div class="mbs-logo">MBS</div>
    <div class="mbs-title"><?= h($title ?? '') ?></div>
    <div class="mbs-breadcrumb">ホーム &gt; <?= h($title ?? '') ?></div>
</div>
