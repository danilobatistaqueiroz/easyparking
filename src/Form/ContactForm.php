<?php
// in src/Form/ContactForm.php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ContactForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    public function validationDefault(Validator $validator)
    {
        $validator->add('name', 'length', [
                'rule' => ['minLength', 3],
                'message' => 'A name is required'
            ])->add('email', 'format', [
                'rule' => 'email',
                'message' => 'A valid email address is required',
            ])->add('body', 'length', [
                'rule' => ['minLength', 5],
                'message' => 'O texto deve conter no mínimo 5 caracteres'
            ]);

        return $validator;
    }

    protected function _execute(array $data)
    {
        // Send an email.
        return true;
    }
	
	public function setErrors($errors)
	{
		$this->_errors = $errors;
	}
	
}