<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
	    <li><?= $this->Html->link(__('Alterar a Senha'), ['action' => 'changePassword', $user->id]) ?> </li>
        <li><?= $this->Html->link(__('Alterar Cadastro'), ['action' => 'edit', $user->id]) ?> </li>
        <!--
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('My Bookmarks'), ['controller' => 'Bookmarks', 'action' => 'my']) ?> </li>
        <li><?= $this->Html->link(__('Search Bookmarks'), ['controller' => 'Bookmarks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bookmark'), ['controller' => 'Bookmarks', 'action' => 'add']) ?> </li>
        -->
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <?php if ($user->type == "admin"): ?>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($user->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Type') ?></th>
                <td><?= h($user->type) ?></td>
            </tr>
	    <?php endif; ?>
        <tr>
            <th scope="row"><?= __('Data do Cadastro') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Última Alteração Cadastral') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <?php if (!empty($user->pedidos)): ?>
        <div class="related">
            <h4><?= __('Suas Solicitações') ?></h4>
            <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('') ?></th>
                <th scope="col"><?= __(Description) ?></th>
                <th scope="col"><?= __(Endereco) ?></th>
                <th scope="col"><?= __('Alugada') ?></th>
                <th scope="col"><?= __('Valor') ?></th>
                <th scope="col" class="actions"><?= __(Actions) ?></th>
            </tr>
            <?php foreach ($user->pedidos as $request): ?>
            <tr>
                <td><?= $this->Html->image($this->Link->url_mini($request->id)) ?></td>
                <td><?= h(substr($request->description,0,50)."...") ?></td>
                <td><?= h($request->address) ?></td>
                <td><?= h($request->title) ?></td>
                <td><?= h($request->request_userid) ?></td>
                <td class="actions">
                    <?= $this->Html->link('Visualizar', 'http://localhost:8765/Parkings/view/'.$request->id, ['fullbase' => true]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Parkings', 'action' => 'edit', $request->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Parkings', 'action' => 'delete', $request->id], ['confirm' => __('Are you sure you want to delete # {0}?', $request->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
    <div class="related">
        <h4><?= __('Seus Quartos') ?></h4>
        <?php if (!empty($user->parkings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('') ?></th>
                <th scope="col"><?= __(Description) ?></th>
                <th scope="col"><?= __(Endereco) ?></th>
                <th scope="col"><?= __('Alugada') ?></th>
                <th scope="col"><?= __('Valor') ?></th>
                <th scope="col" class="actions"><?= __(Actions) ?></th>
            </tr>
            <?php foreach ($user->parkings as $parkings): ?>
            <tr <?php if(!empty($parkings->request_userid)) { echo "style='background-color:red'"; } ?>>
                <td><?= $this->Html->image($this->Link->url_mini($parkings->id)) ?></td>
                <td><?= h(substr($parkings->description,0,50)."...") ?></td>
                <td><?= h($parkings->address) ?></td>
                <td><?= h($parkings->created) ?></td>
                <td><?= h($parkings->modified) ?></td>
                <td class="actions">
                    <?php if (empty($parkings->request_userid)): ?>
                        <?= $this->Html->link('Visualizar', 'http://localhost:8765/Parkings/view/'.$parkings->id, ['fullbase' => true]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Parkings', 'action' => 'edit', $parkings->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Parkings', 'action' => 'delete', $parkings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parkings->id)]) ?>
                    <?php endif; ?>
                    <?php if (!empty($parkings->request_userid)): ?>
                        <?= $this->Html->link(__('Aceitar Solicitacao'), ['controller' => 'Parkings', 'action' => 'edit', $parkings->id]) ?>
                        <BR/>
                        <?= $this->Html->link(__('Recusar Solicitacao'), ['controller' => 'Parkings', 'action' => 'edit', $parkings->id]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Seus Aluguéis') ?></h4>
        <?php
       // echo var_dump($user->lots);
        //echo var_dump($user->alugueis);
        ?>
        <?php if (!empty($user->alugueis)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('') ?></th>
                <th scope="col"><?= __(Description) ?></th>
                <th scope="col"><?= __(Endereco) ?></th>
                <th scope="col"><?= __('Tipo de Pagamento') ?></th>
                <th scope="col"><?= __('Valor') ?></th>
                <th scope="col" class="actions"><?= __(Actions) ?></th>
            </tr>
            <?php foreach ($user->alugueis as $parkings) {
                if ($parkings->client_id===$user->id) {
            ?>
            <tr>
                <td><?= $this->Html->image($this->Link->url_mini($parkings->id)) ?></td>
                <td><?= h(substr($parkings->description,0,50)."...") ?></td>
                <td><?= h($parkings->address) ?></td>
                <td><?= h($parkings->created) ?></td>
                <td><?= h($parkings->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link('Visualizar', 'http://localhost:8765/Parkings/view/'.$parkings->id, ['fullbase' => true]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Parkings', 'action' => 'edit', $parkings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Parkings', 'action' => 'delete', $parkings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parkings->id)]) ?>
                </td>
            </tr>
            <?php
                    } 
                }
            ?>
        </table>
        <?php endif; ?>
    </div>
</div>
