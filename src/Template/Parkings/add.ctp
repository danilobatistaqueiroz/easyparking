<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Parking $parking
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav" style="margin-top:60px">
        <!--
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Parkings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        -->
    </ul>
    <div>
        <?php
          $map_options = array(
            'id' => 'map_canvas',
            'width' => '290px',
            'height' => '450px',
            'style' => '',
            'zoom' => 15,
            'type' => 'ROADMAP',
            'custom' => null,
            'localize' => true,
            'latitude' => -23.55165284,
            'longitude' => -46.68247116,
            'address' => 'Rua Cristiano Viana, 1399',
            'marker' => true,
            'markerTitle' => 'This is my position',
            'markerIcon' => 'http://labs.google.com/ridefinder/images/mm_20_purple.png',
            'markerShadow' => 'http://labs.google.com/ridefinder/images/mm_20_purpleshadow.png',
            'infoWindow' => true,
            'windowText' => 'My Position',
            'draggableMarker' => false
          );
        $marker_options = array(
          'showWindow' => true,
          'windowText' => '<a href="Users/view/2">Users</a>',
          'markerTitle' => 'Github',
          'draggableMarker' => true
        );
        ?>
        <?= $this->Html->script('http://maps.google.com/maps/api/js?key=AIzaSyB5N7JcG5jyCWIvzzRkQfFx78Vkfw0J54I', [false]); ?>
        <?= $this->GoogleMap->map($map_options); ?>
        <?= $this->GoogleMap->addMarker('map_canvas', 1, array('latitude' => -23.55265284, 'longitude' => -46.68447116), $marker_options); ?>
    </div>
</nav>
<div class="parkings form large-9 medium-8 columns content">
    <?= $this->Form->create($parking, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <legend><?= __('Cadastrar um Estacionamento') ?></legend>
        <?php
            echo $this->Form->control('description',['label'=> "Descri\u{00e7}\u{00e3}o", 'maxLength'=>'100']);
            echo $this->Form->control('address',['label'=> "Endere\u{00e7}o", 'maxLength'=>'150']);
            echo $this->Form->control('number', ['label'=> "N\u{00fa}mero", 'maxLength'=>'6', 'onblur'=>'getLatLngFromAddr();']);
            echo $this->Form->control('complement', ['label'=> "Complemento", 'maxLength'=>'10']);
            echo $this->Form->control('zipcode', ['label'=> "Cep", 'maxLength'=>'50', 'onblur'=>'getLatLngFromZip();']);
			echo $this->Form->control('lat', ['type' => 'hidden']);
			echo $this->Form->control('lng', ['type' => 'hidden']);
            echo $this->Form->control('city', ['label'=> "Cidade", 'value'=>"S\u{00e3}o Paulo", 'maxLength'=>'30']);
            echo $this->Form->control('available', ['options'=>['1'=>'Sim','0'=>'Não'], 'label'=>"Disponível", 'value'=>'Sim']);
            echo $this->Form->control('stateOrProvince', ['options' => $estados, 'label'=> 'Estado', 'value'=>'SP']);
            echo $this->Form->control('neighbourhoods', ['label'=> "Refer\u{00ea}ncias [para facilitar a localiza\u{00e7}\u{00e3}o]", 'maxLength'=>'100']);
            echo $this->Form->control('upload1', array('id' => 'upload1', 'type' => 'file'));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?php 
    echo $this->Html->script('addParkings');
?>