<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Datasource\ConnectionManager;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        //All users and guests can access add user page
        $this->Auth->allow(['add']);
    }
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
        Log::write('debug', 'ola');
    }

    public function changePassword()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        
        if(!empty($this->request->getData()))
        {
            $user = $this->Users->patchEntity($user, [
                    'old_password'      => $this->request->getData('old_password'),
                    'password'          => $this->request->getData('new_password'),
                    'new_password'      => $this->request->getData('new_password'),
                    'confirm_password'  => $this->request->getData('confirm_password')
                ],
                ['validate' => 'password']
            );
            if($this->Users->save($user))
            {
                $this->Flash->success('Your password has been changed successfully');
                //Email code
                $this->redirect(['action'=>'view']);
            }
            else
            {
                $this->Flash->error('Error changing password. Please try again!');
            }
        }
        $this->set('user',$user);
    }
    
    public function password()
    {
        Log::write('debug', 'password');
        if ($this->request->is('post')) {
            $query = $this->Users->findByEmail($this->request->getData('email'));
            $user = $query->first();
            if (is_null($user)) {
                $this->Flash->error('Email address does not exist. Please try again');
            } else {
                $passkey = uniqid();
                $url = Router::Url(['controller' => 'users', 'action' => 'reset'], true) . '/' . $passkey;
                $timeout = time() + DAY;
                 if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
                    $this->sendResetEmail($url, $user);
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Error saving reset passkey/timeout');
                }
            }
        }
    }

    private function sendResetEmail($url, $user) {
        Log::write('debug', 'sendResetEmail');
        $email = new Email();
        $email->setTemplate('resetpw');
        $email->setEmailFormat('both');
        $email->setFrom('no-reply@naidim.org');
        $email->setTo($user->email, $user->full_name);
        $email->setSubject('Reset your password');
        $email->setViewVars(['url' => $url, 'username' => $user->username]);
        if ($email->send()) {
            $this->Flash->success(__('Check your email for your reset password link'));
        } else {
            $this->Flash->error(__('Error sending email: ') . $email->smtpError);
        }
    }

    public function reset($passkey = null) {
        Log::write('debug', 'reset');
        Log::write('debug', 'passkey:'.$passkey);
        if ($passkey) {
            $query = $this->Users->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
            $user = $query->first();
            Log::write('debug', 'user:'.$user);
            if ($user) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                        $this->Flash->set(__('Your password has been updated.'));
                        return $this->redirect(array('action' => 'login'));
                    } else {
                        $this->Flash->error(__('The password could not be updated. Please, try again.'));
                    }
                }
            } else {
                $this->Flash->error('Invalid or expired passkey. Please check your email or try again');
                $this->redirect(['action' => 'password']);
            }
            unset($user->password);
            $this->set(compact('user'));
        } else {
            $this->redirect('/');
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Bookmarks','Parkings','Lots','Requests']
        ]);

        //Log::write('debug',var_dump($user->lots));
       // Log::write('debug',var_dump($user->client_id));

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                $this->Auth->setUser($user);
                return $this->redirect(array('controller' => 'Pages', 'action' => 'display'));
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $conn = ConnectionManager::get('default');
                $stmt = $conn->execute("SELECT count(1) as total FROM parkings WHERE owner_id = " . $user['id'] . " and request_userid is not null and request_userid != 0 and request_userid != ''");
                $count = $stmt->fetch('assoc');
                Log::write('debug', $count['total']);
                $this->Flash->default('Você tem novas solicitações de aluguel');
                Log::write('debug', $this->Auth->redirectUrl());
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user)
    {
        //Log::write('debug', 'user:'.json_encode($user));
        $action = $this->request->getParam('action');
        //Log::write('debug', 'action:'.$action);
        if ($user == false) {
            return false;
        }
        // Admin can access all pages
        if ($user['role'] == "admin") {
            return true;
        }
        // Only admin can access index page
        if (in_array($action, ['index']) && strtolower($user['role'])!="admin") {
            return false;
        }
        // Only the owner can view the profile
        if ($this->request->getParam('pass.0') == $user['id']) {
            return true;
        }

        if (in_array($action, ['reset','password','changePassword','sendResetEmail'])) {
            return true;
        }
        return parent::isAuthorized($user);
    }

}
