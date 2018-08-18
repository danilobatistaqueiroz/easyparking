<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <li><?= $this->Html->link(__('Pesquise por estacionamentos'), ['controller' => 'Parkings', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
<?php
echo $this->Html->tag('span','Altere sua senha');
echo $this->Html->tag('p');
echo $this->Form->create($user);
echo $this->Form->control('old_password',['label'=>"Senha Antiga",'type'=>'password']);
echo $this->Form->control('new_password',['label'=>"Nova Senha",'type'=>'password']);
echo $this->Form->control('confirm_password',['label'=>"Confirmar a Nova Senha",'type'=>'password']);
echo $this->Form->button('Enviar');
echo $this->Form->end();
?>
</div>