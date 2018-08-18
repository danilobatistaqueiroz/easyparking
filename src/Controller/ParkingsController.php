<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
/**
 * Parkings Controller
 *
 * @property \App\Model\Table\ParkingsTable $Parkings
 *
 * @method \App\Model\Entity\Parking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParkingsController extends AppController
{
    public $components = array('Paginator');
    public $helpers = array('GoogleMap');

     /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
            'maxLimit' => 7,
            'conditions' => [
                'Parkings.available  ' => '1',
            ]
        ];
        
        //$parkings = $this->paginate($this->Parkings);
        
        //$query = $this->Parkings->find('search', ['search' => $this->request->getQueryParams()]);
        //Log::write('debug'," ");
        //Log::write('debug',$this->Parkings->getSchema());
        //$r = new \ReflectionClass($this->Parkings);
        //print_r($r->getProperties());
        //print_r($r->getMethods());
        //Log::write('debug', print_r($this->Parkings));
        //Log::write('debug',"query::".$query);
        //Log::write('debug'," \r\n ");
        //$query = $this->Parkings->find('search', ['search' => $this->request->getQueryParams()]);
        //$query = $this->Parkings->find('all')->where(['Parkings.id = ' => 5]);
        //$this->set('parkings', $this->paginate($query));
		//Log::write('debug'," ");
		//Log::write('debug',"query::".$query);
        //Log::write('debug'," \r\n ");

        $this->set('parkings', $this->paginate($this->Parkings));
        //$this->set('bookmarks', $this->paginate($query));
        $this->set(compact('parkings'));
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->Auth->allow(['add']);
    }
	
    /**
     * View method
     *
     * @param string|null $id Parking id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
	Log::write('debug', 'view');
        $parking = $this->Parkings->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('parking', $parking);
    }

    public function solicitar(){
        Log::write('debug', 'Solicitar');
        $this->Flash->set('Solicitação enviada para o dono.', [
            'element' => 'success'
        ]);
        $this->setAction('index');
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $parking = $this->Parkings->newEntity();
	$estados = $this->estados();
        if ($this->request->is('post')) {
            $parking = $this->Parkings->patchEntity($parking, $this->request->getData());
            $parking->owner_id = $this->Auth->user('id');
            if ($this->Parkings->save($parking)) {
                Log::write('debug', $parking->id);
                Log::write('debug', $this->request->getData('upload'));
                Log::write('debug', $this->request->getData('upload')['name']);
		$this->addImage($parking);
                $this->Flash->success(__('O estacionamento foi salvo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The parking could not be saved. Please, try again.'));
        }
        $users = $this->Parkings->Users->find('list', ['limit' => 200]);
	$this->set(compact('estados', $estados));
        $this->set(compact('parking', 'users'));
    }
    
    private function addImage($parking)
    {
        if(!empty($this->request->getData('upload')['name']))
        {
            $file = $this->request->getData('upload'); //put the data into a var for easy use
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'gif', 'png', 'ico'); //set allowed extensions
            if(in_array($ext, $arr_ext))
            {
                $pid = str_pad($parking->id,8,"0",STR_PAD_LEFT);
                $filepath = WWW_ROOT . 'img' . DS . 'parkings' . DS . $pid . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $filepath);
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Parking id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $parking = $this->Parkings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $parking = $this->Parkings->patchEntity($parking, $this->request->getData());
            if ($this->Parkings->save($parking)) {
                $this->Flash->success(__('The parking has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The parking could not be saved. Please, try again.'));
        }
        $users = $this->Parkings->Users->find('list', ['limit' => 200]);
        $this->set(compact('parking', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Parking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $parking = $this->Parkings->get($id);
        if ($this->Parkings->delete($parking)) {
            $this->Flash->success(__('The parking has been deleted.'));
        } else {
            $this->Flash->error(__('The parking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        if ($user == false) {
            return false;
        }
        // The add action is always allowed.
        if (in_array($action, ['add','index','view','solicitar'])) {
            return true;
        }
        // Only the owner can view the profile
        if ($this->request->getParam('pass.0') == $user['id']) {
            return true;
        }
        return parent::isAuthorized($user);
    }
}
