<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'Quartos : Encontre um quarto ou ganhe dinheiro com seu quarto';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
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
<body class="home">

    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
				<?php if($logged==true): ?>
					<h1><a href="/Users/view/<?= $user_id ?>">Seu Cadastro </a></h1>
				<?php endif; ?>
				<?php if($logged==false): ?>
					<h1><a href="/">Quartos</a></h1>
				<?php endif; ?>
            </li>
        </ul>
        <div class="top-bar-section">
			<ul class="left">
				<li><a href="Parkings">Quartos para alugar</a></li>
				<li><a href="Parkings/add">Aluge o teu quarto</a></li>
			</ul>
            <ul class="right">
				<li><a href="Help/howitworks">Como funciona</a></li>
                <li><a href="/contact">Contato</a></li>
				<?php if($logged==false) : ?>
					<li><a href="Users/add">Cadastro</a></li>
                    <li><a href="Users/login">Entrar</a></li>
				<?php endif; ?>
				<?php if($logged==true) : ?>
					<li><a href="Users/logout">Sair</a></li>
				<?php endif; ?>
            </ul>
        </div>
    </nav>


</body>
</html>
