<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Parking $parking
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Parkings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        
    </ul>
</nav>
<div class="parkings form large-9 medium-8 columns content">
    <?= $this->Form->create($parking, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <legend><?= __('Cadastrar um Estacionamento') ?></legend>
        <?php
            echo $this->Form->control('description',['label'=> "Descri\u{00e7}\u{00e3}o"]);
            echo $this->Form->control('address',['label'=> "Endere\u{00e7}o"]);
            echo $this->Form->control('number', ['label'=> "N\u{00fa}mero"]);
            echo $this->Form->control('complement', ['label'=> "Complemento"]);
            echo $this->Form->control('zipcode', ['label'=> "Cep"]);
            echo $this->Form->control('city', ['label'=> "Cidade", 'value'=>"S\u{00e3}o Paulo"]);
            echo $this->Form->control('available', ['label'=> "Disponível", 'value'=>"true"]);
            echo $this->Form->control('stateOrProvince', ['options' => ['AL','AM','AP','AC','BA','ES','GO','SP','MG','PR','RS','SC','RJ','RO','RM'], 'label'=> 'Estado', 'value'=>'7']);
            echo $this->Form->control('references', ['label'=> "Refer\u{00ea}ncias [para facilitar a localiza\u{00e7}\u{00e3}o]"]);
            
            //echo $this->Form->create('User', array('url' => array('action' => 'create'), 'enctype' => 'multipart/form-data'));
            echo $this->Form->control('upload', array('type' => 'file'));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
