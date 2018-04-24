<?php
echo $this->Html->tag('span','Contato');
echo $this->Html->tag('p');
echo $this->Form->create($contact);
echo $this->Form->control('name');
echo $this->Form->control('email');
echo $this->Form->control('body');
echo $this->Form->button('Submit');
echo $this->Form->end();