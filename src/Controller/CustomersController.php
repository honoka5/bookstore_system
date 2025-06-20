<?php
declare(strict_types=1);

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Customers Controller
 */
class CustomersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Customers->find();
        $keyword = $this->request->getQuery('keyword');
    if (!empty($keyword)) {
        $query->where([
            'OR' => [
                'name LIKE' => '%' . $keyword . '%',
                'phone_number LIKE' => '%' . $keyword . '%',
                'contact_person LIKE' => '%' . $keyword . '%',
            ]
        ]);
    }
    $customers = $this->paginate($query);
    $this->set(compact('customers'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $customer = $this->Customers->get($id, contain: []);
        $this->set(compact('customer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEmptyEntity();
         // Excelアップロード処理
    if ( $this->request->is('post') &&
        $this->request->getData('excel_upload') !== null) {
        $file = $this->request->getData('excel_file');
        if ($file->getError() === UPLOAD_ERR_OK) {
            $spreadsheet = IOFactory::load($file->getStream()->getMetadata('uri'));
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // 1行目はヘッダーとしてスキップ
            foreach (array_slice($rows, 1) as $row) {
                $entity = $this->Customers->newEntity([
                    'name' => $row[0] ?? '',
                    'phone_number' => $row[1] ?? '',
                    'contact_person' => $row[2] ?? '',
                ]);
                $this->Customers->save($entity);
            }
            $this->Flash->success('Excelから顧客を一括登録しました。');
            return $this->redirect(['action' => 'index']);
        }
    }

    // 通常のフォーム登録
    if ($this->request->is('post') && $this->request->getData('excel_upload') === null) {
        $customer = $this->Customers->patchEntity($customer, $this->request->getData());
        if ($this->Customers->save($customer)) {
            $this->Flash->success(__('The customer has been saved.'));
 return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The customer could not be saved. Please, try again.'));
    }
    $this->set(compact('customer'));
}

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $customer = $this->Customers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));

        return null;
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
