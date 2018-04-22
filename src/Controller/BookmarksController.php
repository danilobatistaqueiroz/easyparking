<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\BookmarksTable $Bookmarks
 *
 * @method \App\Model\Entity\Bookmark[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BookmarksController extends AppController
{

	public $components = array('Paginator');
	
	
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
        
        $bookmarks = $this->paginate($this->Bookmarks);
		
		$query = $this->Bookmarks->find('search', ['search' => $this->request->getQueryParams()]);

			//Log::write('debug'," ");
			//Log::write('debug',"query::".$query);
			//Log::write('debug'," \r\n ");
			
		$this->set('bookmarks', $this->paginate($query));
		
		//$this->set('bookmarks', $this->paginate($this->Bookmarks));
        $this->set(compact('bookmarks'));
		$this->set('_serialize', ['bookmarks']);
		
    }
    
    public function my()
    {
        $this->paginate = [
            'contain' => ['Users'],
			'conditions' => ['Bookmarks.user_id' => $this->Auth->user('id'),]
			//'maxLimit' => 4,
			//'limit' => 6
        ];
        $bookmarks = $this->paginate($this->Bookmarks);
		
		$query = $this->Bookmarks->find('search', ['search' => $this->request->getQueryParams()]);

			Log::write('debug'," ");
			Log::write('debug',"query::".$query);
			Log::write('debug'," \r\n ");
			
		$this->set('bookmarks', $this->paginate($query));
		
		//$this->set('bookmarks', $this->paginate($this->Bookmarks));
        $this->set(compact('bookmarks'));
		$this->set('_serialize', ['bookmarks']);
		
    }
    /*
	public function clean(){
		Log::write('debug',"clean");
        $this->paginate = [
            'contain' => ['Users'],
			'conditions' => ['Bookmarks.user_id' => $this->Auth->user('id'),]
        ];
        $bookmarks = $this->paginate($this->Bookmarks);
		$this->set('bookmarks', $this->paginate($this->Bookmarks));
        $this->set(compact('bookmarks'));
		$this->set('_serialize', ['bookmarks']);
	}
	public function Pesquisar(){
		Log::write('debug', "Pesquisar");
	}
	public function search(){
		Log::write('debug',"search");
		$query = $this->Bookmarks
			->find('search',['search' => $this->request->query])
			->contain(['Users','Categories'])
			->where(['title like' => 'b']);
		$this->set(compact('bookmarks', $this->paginate($query)));
	}
    */
	
    /**
     * View method
     *
     * @param string|null $id Bookmark id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookmark = $this->Bookmarks->get($id, [
            'contain' => ['Users', 'Tags']
        ]);

        $this->set('bookmark', $bookmark);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bookmark = $this->Bookmarks->newEntity();
        if ($this->request->is('post')) {
            $bookmark = $this->Bookmarks->patchEntity($bookmark, $this->request->getData());
			$bookmark->user_id = $this->Auth->user('id');
            if ($this->Bookmarks->save($bookmark)) {
                $this->Flash->success(__('The bookmark has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookmark could not be saved. Please, try again.'));
        }
        $tags = $this->Bookmarks->Tags->find('list', ['limit' => 200]);
		$this->set(compact('bookmark', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookmark id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function edit($id = null)
	{
		$bookmark = $this->Bookmarks->get($id, [
			'contain' => ['Tags']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$bookmark = $this->Bookmarks->patchEntity($bookmark, $this->request->getData());
			$bookmark->user_id = $this->Auth->user('id');
			if ($this->Bookmarks->save($bookmark)) {
				$this->Flash->success('The bookmark has been saved.');
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error('The bookmark could not be saved. Please, try again.');
		}
		$tags = $this->Bookmarks->Tags->find('list', ['limit' => 200]);
		$this->set(compact('bookmark', 'users', 'tags'));
		$this->set('_serialize', ['bookmark']);
	}

    /**
     * Delete method
     *
     * @param string|null $id Bookmark id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookmark = $this->Bookmarks->get($id);
        if ($this->Bookmarks->delete($bookmark)) {
            $this->Flash->success(__('The bookmark has been deleted.'));
        } else {
            $this->Flash->error(__('The bookmark could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

	
	public function tags()
	{
		// The 'pass' key is provided by CakePHP and contains all
		// the passed URL path segments in the request.
		$tags = $this->request->getParam('pass');

		// Use the BookmarksTable to find tagged bookmarks.
		//Log::write('debug',"tags:".$tags[0]);
		$bookmarks = $this->Bookmarks->find('tagged', [
			'tags' => $tags
		]);

		// Pass variables into the view template context.
		$this->set([
			'bookmarks' => $bookmarks,
			'tags' => $tags
		]);
	}

	public function isAuthorized($user)
	{
		$action = $this->request->getParam('action');

		// The add and index actions are always allowed.
		if (in_array($action, ['index', 'add', 'tags'])) {
			return true;
		}
		// All other actions require an id.
		if (!$this->request->getParam('pass.0')) {
			return false;
		}

		// Check that the bookmark belongs to the current user.
		$id = $this->request->getParam('pass.0');
		$bookmark = $this->Bookmarks->get($id);
		if ($bookmark->user_id == $user['id']) {
			return true;
		}
		return parent::isAuthorized($user);
	}
	
}
