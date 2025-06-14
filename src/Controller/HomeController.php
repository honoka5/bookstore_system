<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\Table;

/**
 * Home Controller
 */
class HomeController extends AppController
{
    // /**
    //  * Home Table instance
    //  *
    //  * @var \App\Model\Table\HomeTable
    //  */
    protected $home;

    // }
    /**
     * @var \Cake\ORM\Table
     */
    public Table $Home;

    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        //     $this->home = $this->fetchTable('Homes');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('default');

        return null;
    }

    /**
     * View method
     *
     * @param string|null $id Home id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id)
    {
        $home = $this->home->get($id, contain: []);
        $this->set(compact('home'));

        return null;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $home = $this->home->newEmptyEntity();
        if ($this->request->is('post')) {
            $home = $this->home->patchEntity($home, $this->request->getData());
            if ($this->home->save($home)) {
                $this->Flash->success(__('The home has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The home could not be saved. Please, try again.'));
        }
        $this->set(compact('home'));

        return null;
    }

    public function edit(?string $id)
    {
        $home = $this->home->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $home = $this->home->patchEntity($home, $this->request->getData());
            if ($this->home->save($home)) {
                $this->Flash->success(__('The home has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The home could not be saved. Please, try again.'));
        }
        $this->set(compact('home'));

        return null;
    }

    public function delete(?string $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $home = $this->home->get($id);
        if ($this->home->delete($home)) {
            $this->Flash->success(__('The home has been deleted.'));
        } else {
            $this->Flash->error(__('The home could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
