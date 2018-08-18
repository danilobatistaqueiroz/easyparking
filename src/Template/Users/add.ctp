<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __("A\u{00e7}\u{00f5}es") ?></li>
        <li><?= $this->Html->link(__('Pesquise por estacionamentos'), ['controller' => 'Parkings', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Cadastro') ?></legend>
        <?php
            echo $this->Form->control('email', ['label'=>'Seu email']);
            echo $this->Form->control('password', ['label'=>"Sua senha"]);
            echo $this->Form->control('confirm_password', ['label'=>"Confirme a senha", 'required'=>'true']);
            echo $this->Form->control('name', ['label'=>"Seu nome"]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Cadastrar')) ?>
    <?= $this->Form->end() ?>
</div>
