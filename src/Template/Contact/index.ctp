<body>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __(Actions) ?></li>
        <li><?= $this->Html->link(__('Pesquise por estacionamentos'), ['controller' => 'Parkings', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
<?php  
		$logged = false;
		$session = $this->request->getSession();
        $user_data = $session->read('Auth.User');
		$user_id = $user_data["id"];
        if(!empty($user_data)){
			$logged = true;
		} else {
			$logged = false;
		}
?>
<?php
echo $this->Html->tag('span','Entre em Contato Conosco');
echo $this->Html->tag('p');
echo $this->Form->create(null,['url'=>'/contact/send','type'=>'post']);
if($logged==false) {
	echo $this->Form->control('name',['label'=>"Seu nome"]);
	echo $this->Form->control('email',['label'=>"Seu email"]);
}
echo $this->Form->control('body',['label'=>"Sua mensagem", 'required'=>'true']);
echo $this->Form->button('Enviar');
echo $this->Form->end();
?>
</div>
<?= $this->Flash->render() ?>
</body>