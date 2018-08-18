<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php $this->Html->script('users.js'); ?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('username');
        ?>
    </fieldset>
    <?= $this->Form->button("Cancelar", array(
        "type"=>"button", 
        "name" => "Cancel", 
        "style" => "margin-left:5px;float:right",
        "onclick" => __("location.href='/Users/view/{0}'", $user->id)
        )
    ) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
