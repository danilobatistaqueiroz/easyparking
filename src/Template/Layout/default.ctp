<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<?php  
		$logged = false;
		$session = $this->request->getSession();
        $user_data = $session->read('Auth.User');
        if(!empty($user_data)){
            //print_r($user_data);
			$logged = true;
		} else {
			$logged = false;
		}
?>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href="">Quartos</a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
			<ul class="left">
				<li><a href="">Quartos para Alugar</a></li>
				<li><a href="">Coloque para Alugar</a></li>
			</ul>
            <ul class="right">
				<li><a href="Help/howitworks">Como funciona</a></li>
                <li><a href="/contact">Contato</a></li>
				<?php if($logged==false) : ?>
					<li><a href="Users/add">Cadastro</a></li>
                    <li><a href="Users/login">Entrar</a></li>
				<?php endif; ?>
				<?php if($logged==true) : ?>
					<li><a href="users/logout">Sair</a></li>
				<?php endif; ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
