<?php
// In a controller
namespace App\Controller;

use App\Controller\AppController;
use App\Form\ContactForm;

class ContactController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
    }
    
    public function index()
    {        
        $contact = new ContactForm();
        if ($this->request->is('post')) {
            if ($contact->execute($this->request->getData())) {
                $this->Flash->success('We will get back to you soon.');
            } else {
                $this->Flash->error('There was a problem submitting your form.');
            }
        }
        if ($this->request->is('get')) {
            $session = $this->request->getSession();
            $user_data = $session->read('Auth.User');
            if(!empty($user_data)){
                $this->request->data['name'] = $user_data['name'];
                $this->request->data['email'] = $user_data['email'];
            }
        }
        $this->set('contact', $contact);
    }
}