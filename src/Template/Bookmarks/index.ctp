<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bookmark[]|\Cake\Collection\CollectionInterface $bookmarks
 */
$session = $this->request->getSession();
$user_data = $session->read('Auth.User');
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Bookmark'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('My Bookmarks'), ['action' => 'my']) ?></li>
        <li><?= $this->Html->link(__('My Cars'), ['controller' => 'Cars', 'action' => 'index']) ?></li>
        <?php if($user_data['type']=='admin') : ?>
            <li><?= $this->Html->link(__('All Cars'), ['controller' => 'Cars', 'action' => 'all']) ?></li>
		<?php endif; ?>
    </ul>
    <div style="margin-top:100px">
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
<div class="bookmarks index large-9 medium-8 columns content">
    <h3><?= __('Bookmarks') ?></h3>
	<?= $this->Form->create(null,['valueSources' => 'query']); ?>
    <?= $this->Form->control('Pesquisar');  ?>
    <?= $this->Form->button('Filter', ['action'=>'index']);  ?>
	<?= $this->Form->button('Reset', ['type'=>'button', 'onclick'=>'document.all(\'pesquisar\').value=\'\';document.forms[0].submit();
']); ?>
    <?= $this->Form->end();  ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
				<th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookmarks as $bookmark): ?>
            <tr>
                <td><?= $this->Number->format($bookmark->id) ?></td>
                <td><?= $bookmark->has('user') ? $this->Html->link($bookmark->user->id, ['controller' => 'Users', 'action' => 'view', $bookmark->user->id]) : '' ?></td>
                <td><?= h($bookmark->title) ?></td>
				<td><?= h($bookmark->description) ?></td>
                <td><?= h($bookmark->created) ?></td>
                <td><?= h($bookmark->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bookmark->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bookmark->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bookmark->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookmark->id)]) ?>
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
</div>