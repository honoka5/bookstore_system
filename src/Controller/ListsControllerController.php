<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ListsController Controller
 *
 */
class ListsControllerController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $query = $this->ListsController->find();
        // $listsController = $this->paginate($query);

        // $this->set(compact('listsController'));
         $this->viewBuilder()->setLayout('default');

        
    }

    /**
     * View method
     *
     * @param string|null $id Lists Controller id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $listsController = $this->ListsController->get($id, contain: []);
        $this->set(compact('listsController'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $listsController = $this->ListsController->newEmptyEntity();
        if ($this->request->is('post')) {
            $listsController = $this->ListsController->patchEntity($listsController, $this->request->getData());
            if ($this->ListsController->save($listsController)) {
                $this->Flash->success(__('The lists controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lists controller could not be saved. Please, try again.'));
        }
        $this->set(compact('listsController'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lists Controller id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $listsController = $this->ListsController->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $listsController = $this->ListsController->patchEntity($listsController, $this->request->getData());
            if ($this->ListsController->save($listsController)) {
                $this->Flash->success(__('The lists controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lists controller could not be saved. Please, try again.'));
        }
        $this->set(compact('listsController'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lists Controller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $listsController = $this->ListsController->get($id);
        if ($this->ListsController->delete($listsController)) {
            $this->Flash->success(__('The lists controller has been deleted.'));
        } else {
            $this->Flash->error(__('The lists controller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
