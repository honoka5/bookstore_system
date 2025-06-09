

<h1>一覧メニュー</h1>

<p><?= $this->Html->link('顧客一覧', ['controller' => 'Customers', 'action' => 'index'], ['class' => 'button']) ?></p>
<p><?= $this->Html->link('注文書一覧', ['controller' => 'Orders', 'action' => 'index'], ['class' => 'button']) ?></p>
<p><?= $this->Html->link('納品書一覧', ['controller' => 'Deliveries', 'action' => 'index'], ['class' => 'button']) ?></p>

<style>
.button {
    display: inline-block;
    margin: 8px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 20px;
    text-decoration: none;
}
.button:hover {
    background-color: #0056b3;
}
</style>