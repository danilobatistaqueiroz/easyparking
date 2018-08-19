<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Parking[]|\Cake\Collection\CollectionInterface $parkings
 */
$session = $this->request->getSession();
$user_data = $session->read('Auth.User');
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <!--ul class="side-nav">
        <li class="heading"><?= __('Ações') ?></li>
        <li><?= $this->Html->link(__('Encontre um quarto'), ['controller'=>'Parkings','action' => 'index']) ?></li>
    </ul-->
    <div style="margin-top:50px">
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
            'markerTitle' => 'Seu endereço',
            'markerIcon' => 'http://labs.google.com/ridefinder/images/mm_20_purple.png',
            'markerShadow' => 'http://labs.google.com/ridefinder/images/mm_20_purpleshadow.png',
            'infoWindow' => true,
            'windowText' => 'Seu endereço',
            'draggableMarker' => false
          );

        ?>
        <?= $this->Html->script('http://maps.google.com/maps/api/js?key=AIzaSyB5N7JcG5jyCWIvzzRkQfFx78Vkfw0J54I', [false]); ?>
        <?= $this->GoogleMap->map($map_options); ?>
        <?php   
            class Mark { 
                public $lat; 
                public $lng; 
                public function __construct($lat, $lng) {
                    $this->lat = $lat;
                    $this->lng = $lng;
                }
            }
            $markers = [];
            foreach ($parkings as $parking) {
                $marker_options = array(
                    'showWindow' => true,
                    'windowText' => '<a href="Parking/view/"'.$parking->id.'>'.$parking->address.','.$parking->number.'</a>',
                    'markerTitle' => $parking->title,
                    'draggableMarker' => true
                    );
                echo $this->GoogleMap->addMarker('map_canvas', 1, 
                array('latitude' => $parking->lat, 'longitude' => $parking->lng), $marker_options); 
                $markers[] = (new Mark($parking->lat, $parking->lng));
            }
        ?>
    </div>
</nav>
<script>
<?php
            echo 'var markers = [';
            foreach ($markers as $marker) {
                echo '{lat:' . $marker->lat . ',';
                echo ' lng:' . $marker->lng . '},';
            }
            echo '];';
?>
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < markers.length; i++) {
        bounds.extend(markers[i]);
    }
    map_canvas.fitBounds(bounds);
</script>
<div class="parkings index large-9 medium-8 columns content">
    <h3><?= __('Quartos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('address', ['label'=>"Endereço"]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('number', ['label'=>"Número"]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('zipcode', ['label'=>'Cep']) ?></th>
				<th scope="col"><?= $this->Paginator->sort('city', ['label'=>'Cidade']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('available', ['label'=>'Disponível']) ?></th>
				<th scope="col"><?= $this->Paginator->sort('stateOrProvince', ['label'=>'Estado']) ?></th>
                <th scope="col" class="actions"><?= __("Ações") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parkings as $parking): ?>
            <tr>
                <td><?= h($parking->address) ?></td>
                <td><?= $this->Number->format($parking->number, ['locale'=>'pt_BR']) ?></td>
                <td><?= h($parking->zipcode) ?></td>
				<td><?= h($parking->city) ?></td>
                <td><?= h($parking->available) ?></td>
				<td><?= h($parking->stateOrProvince) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $parking->id]) ?>
                    <?php if($user_data["role"]==="admin"): ?>
                        <?= $this->Html->link(__('Edita'), ['action' => 'edit', $parking->id]) ?>
                        <?= $this->Form->postLink(__('Deleta'), ['action' => 'delete', $parking->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parking->id)]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
    <?= $this->Flash->render() ?>
</div>
