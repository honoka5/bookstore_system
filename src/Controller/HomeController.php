<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\Table;

/**
 * Home Controller
 */
class HomeController extends AppController
{
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
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('default');

        
    }
}
