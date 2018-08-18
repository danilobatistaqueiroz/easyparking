<?php
// In a controller
namespace App\Controller;

use App\Controller\AppController;
use App\Form\ContactForm;
use Cake\Mailer\Email;
use Cake\Log\Log;

class ContactController extends AppController
{
    public function initialize()
    {
        Log::write('debug', 'initialize');
        Log::write('debug', $_SERVER['REQUEST_METHOD']);
        parent::initialize();
        $this->Auth->allow();
    }
    
    public function index()
    {
    }
        
    public function send(){
        $this->limparLogDebug();
        Log::write('debug', 'contato');
        Log::write('debug', $_SERVER['REQUEST_METHOD']);

        $contact = new ContactForm();
        $session = $this->request->getSession();
        $user_data = $session->read('Auth.User');
        //Log::write('debug', 'data:'.$this->request->getQuery('name'));
        //Log::write('debug', 'email:'.$this->request->getQuery('email'));
        Log::write('debug', 'email:'.$this->request->getData('email'));
        $name = "";
        $email = "";
        if(!empty($user_data)){
            $name = $user_data['name'];
            $this->request->withData('name', $name);
            $email = $user_data['email'];
            $this->request->withData('email', $email);
        } else {
            $name = $this->request->getData('name');
            $email = $this->request->getData('email');
        }
        $body = $this->request->getData('body');
        Log::write('debug', 'post:'.$this->request->is('post'));
        if ($this->request->is('post')) {
            if ($contact->execute($this->request->getData())) {
                $this->sendEmail($email, $name, $body);
                $this->Flash->success('We will get back to you soon.');
            } else {
                $errors = $contact->errors();
                $this->Flash->error('There was a problem submitting your form.');
                $this->imprimeErros($errors);
                //$strErrors = $this->array2string($errors);
                //Log::write('debug', $strErrors);
            }
        }
        $this->set('contact', $contact);
        $this->redirect($this->referer());
        //return $this->redirect('/');
    }
	
	private function imprimeErros($data){
            foreach ($data as $key => $value) {
                if(is_array($value)){
                    $this->imprimeErros($value);
                } else {
                    $this->Flash->error($value);
                }
            }
	}
	
	function array2string($data){
            $log_a = "";
            foreach ($data as $key => $value) {
                if(is_array($value))    $log_a .= "[".$key."] => (". $this->array2string($value). ") \n";
                else                    $log_a .= "[".$key."] => ".$value."\n";
            }
            return $log_a;
	}
	
	private function sendEmail($address, $name, $texto){
            Log::write('debug', 'sendEmail:'.$address);
            Log::write('debug', 'sendEmail:'.$name);

            $email = new Email('gmail');
            //$email->setProfile(['from' => 'danilobatistaqueiroz@gmail.com']);
            $email->from(['danilobatistaqueiroz@gmail.com' => 'iParkings'])
                ->setTo('dbq.batista@gmail.com')
                ->setSubject('Contato - ' . $name)
                ->send('email:'.$address.' - mensagem:'.$texto);
	}
}