<h1>ホーム</h1>

<p><?= $this->Html->link('注文管理', ['controller' => 'Orders', 'action' => 'index'], ['class' => 'button']) ?></p>
<p><?= $this->Html->link('納品書管理', ['controller' => 'Deliveries', 'action' => 'index'], ['class' => 'button']) ?></p>
<p><?= $this->Html->link('注文書作成', ['controller' => 'RegOrders', 'action' => 'selectCustomer'], ['class' => 'button']) ?></p>
<p></p>
<p></p>

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
