<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Parking $parking
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <!--ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Parking'), ['action' => 'edit', $parking->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Parking'), ['action' => 'delete', $parking->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parking->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Parkings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parking'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul-->
</nav>
<div class="parkings view large-9 medium-8 columns content">
    <h3><?= h($parking->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $parking->has('user') ? $this->Html->link($parking->user->id, ['controller' => 'Users', 'action' => 'view', $parking->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($parking->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zipcode') ?></th>
            <td><?= h($parking->zipcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($parking->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number') ?></th>
            <td><?= $this->Number->format($parking->number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lat') ?></th>
            <td><?= $this->Number->format($parking->lat) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lng') ?></th>
            <td><?= $this->Number->format($parking->lng) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($parking->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($parking->modified) ?></td>
        </tr>
    </table>
    <?= $this->Form->create(null, ['type' => 'put', 
    'url' => ['controller' => 'Parkings', 'action' => 'solicitar']]) ?>
    <fieldset>
        <?php
            echo $this->Form->control('owner_id', ['type' => 'hidden']);
            echo $this->Form->control('id', ['type' => 'hidden', 'value' => $parking->id]);
            echo $this->Form->control('solicitar', ['type' => 'hidden', 'value' => 'aluguel']);
        ?>
    </fieldset>
    <?= $this->Form->button('Solicitar aluguel', ['type' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>

