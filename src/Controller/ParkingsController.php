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
            'maxLimit' => 7
        ];
        
        //$parkings = $this->paginate($this->Parkings);
        
		//$query = $this->Parkings->find('search', ['search' => $this->request->getQueryParams()]);
		//Log::write('debug'," ");
		//Log::write('debug',"query::".$query);
		//Log::write('debug'," \r\n ");

        $this->set('parkings', $this->paginate($this->Parkings));
        //$this->set('bookmarks', $this->paginate($query));
        $this->set(compact('parkings'));
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
        $parking = $this->Parkings->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('parking', $parking);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        echo 'add method';
        $parking = $this->Parkings->newEntity();
        if ($this->request->is('post')) {
            $parking = $this->Parkings->patchEntity($parking, $this->request->getData());
            $parking->user_id = $this->Auth->user('id');
            if ($this->Parkings->save($parking)) {
                $this->Flash->success(__('The parking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The parking could not be saved. Please, try again.'));
        }
        $users = $this->Parkings->Users->find('list', ['limit' => 200]);
        $this->set(compact('parking', 'users'));
        
        $this->addImage();
    }
    
public function create()
{
    echo "create method";
}

public function addImage()
{
    echo 'addImage method';
    $parking = $this->Parkings->newEntity();
    //Check if image has been uploaded
    
    if ($this->request->is('post')) 
    {
    $parking = $this->Parkings->patchEntity($parking, $this->request->data);
    print_r("file name:".$this->request->data['parkings']);
    }
    if(!empty($this->request->getParam('parkings')['upload']['name']))
    {
        $file = $this->request->getParam('parkings')['upload']; //put the data into a var for easy use

        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
        $arr_ext = array('jpg', 'jpeg', 'gif', 'png', 'ico'); //set allowed extensions

        //only process if the extension is valid
        if(in_array($ext, $arr_ext))
        {
            //do the actual uploading of the file. First arg is the tmp name, second arg is
            //where we are putting it
            echo "file name for upload".$file['tmp_name'], WWW_ROOT . 'img' . DS . $file['name'];
            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img' . DS . $file['name']);

            //prepare the filename for database entry
            //$this->getData['Images']['image'] = $file['name'];
            
            return $this->redirect(['action' => 'index']);
        }
    }
    $users = $this->Parkings->Users->find('list', ['limit' => 200]);
    $this->set(compact('parking', 'users'));
/*
    if ($this->request->is('post')) {
        $image = $this->Parkings->patchEntity($image, $this->request->data);
        if ($this->Parkings->save($image)) {
            $this->Flash->success('The image has been saved.');
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error('The image could not be saved. Please, try again.');
        }
    }
    $this->set(compact('image'));
    $this->set('_serialize', ['image']);
*/
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
}
