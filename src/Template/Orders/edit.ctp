<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $order->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Stores'), ['controller' => 'Stores', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Store'), ['controller' => 'Stores', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orders form large-9 medium-8 columns content">
    <?= $this->Form->create($order) ?>
    <fieldset>
        <legend><?= __('Edit Order') ?></legend>
        <?php
            echo $this->Form->control('code');
            echo $this->Form->control('total');
            echo $this->Form->control('latitude');
            echo $this->Form->control('longitude');
            echo $this->Form->control('address');
            echo $this->Form->control('status');
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('store_id', ['options' => $stores, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
