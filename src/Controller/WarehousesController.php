<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use Cake\Filesystem\Folder;
use Cake\Core\Configure;

/**
 * Warehouses Controller
 *
 * @property \App\Model\Table\WarehousesTable $Warehouses
 *
 * @method \App\Model\Entity\Warehouse[] paginate($object = null, array $settings = [])
 */
class WarehousesController extends AppController
{

    public function isAuthorized($store)
    {
        if (in_array($this->request->getParam('action'), ['index', 'delete', 'active', 'getLastRowAjax'])) {
            if (isset($store['role']) && $store['role'] === 1) {
                return true;
            } else {
                return false;
            }
        }
        if (in_array($this->request->getParam('action'), ['edit'])) {
            $warehouseId = (int) $this->request->getParam('pass.0');
            if ($this->Warehouses->isOwnedBy($warehouseId, $store['id'])) {
                return true;
            } else {
                return false;
            }
        }
        if (in_array($this->request->getParam('action'), ['view'])) {
            $warehouseId = (int) $this->request->getParam('pass.0');
            if ($this->Warehouses->isOwnedBy($warehouseId, $store['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($store);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products'],
            'order' => [
                'Warehouses.created' => 'desc'
            ]
        ];
        $warehouses = $this->paginate($this->Warehouses->find()->where(['Warehouses.store_id' => $this->Auth->user('id')]));

        $this->set('date_format', Configure::read('DATE_FORMAT'));
        $this->set(compact('warehouses'));
        $this->set('_serialize', ['warehouses']);
    }

    /**
     * View method
     *
     * @param string|null $id Warehouse id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $warehouse = $this->Warehouses->get($id, [
            'contain' => [
                'Products' => function($q) { return $q->select(['Products.id', 'Products.name', 'Products.path', 'Products.image']); }, 
                'Stores' => function($q) { return $q->select(['Stores.id', 'Stores.role', 'Stores.name']); }]
        ]);

        $this->set('warehouse', $warehouse);
        $this->set('_serialize', ['warehouse']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $warehouse = $this->Warehouses->newEntity();
        if ($this->request->is('post')) {
            $warehouse = $this->Warehouses->patchEntity($warehouse, $this->request->getData());
            if ($this->Warehouses->save($warehouse)) {
                $this->Flash->success(__('The warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warehouse could not be saved. Please, try again.'));
        }
        $products = $this->Warehouses->Products->find('list', ['limit' => 200]);
        $stores = $this->Warehouses->Stores->find('list', ['limit' => 200]);
        $this->set(compact('warehouse', 'products', 'stores'));
        $this->set('_serialize', ['warehouse']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Warehouse id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $warehouse = $this->Warehouses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $warehouse = $this->Warehouses->patchEntity($warehouse, $this->request->getData());
            if ($this->Warehouses->save($warehouse)) {
                $this->Flash->success(__('The warehouse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warehouse could not be saved. Please, try again.'));
        }
        $products = $this->Warehouses->Products->find('list', ['limit' => 200]);
        $stores = $this->Warehouses->Stores->find('list', ['limit' => 200]);
        $this->set(compact('warehouse', 'products', 'stores'));
        $this->set('_serialize', ['warehouse']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Warehouse id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $warehouse = $this->Warehouses->get($id);
        if ($this->Warehouses->delete($warehouse)) {
            $this->Flash->success(__('El registro fue eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function active($id = null)
    {
        $this->request->allowMethod(['post']);
        $warehouse = $this->Warehouses->get($id);
        $warehouse->active = !$warehouse->active;
        if ($this->Warehouses->save($warehouse)) {
            if ($warehouse->active) {
                $this->Flash->success(__('El registro fue activado.'));
            } else {
                $this->Flash->success(__('El registro fue desactivado.'));
            }
        } else {
            $this->Flash->error(__('No se pudo cambiar el estado, por favor intentelo nuevamente.'));
        }

        return $this->redirect($this->referer());
    }

    public function getLastRowAjax()
    {
        $lastRow = [];
        if ($this->request->is('ajax')) {       
            $tempData = $this->Warehouses->find()
                ->select(['Warehouses.id', 'Warehouses.created'])
                ->where(['Warehouses.store_id' => $this->Auth->user('id')])
                ->order(['Warehouses.id' => 'asc']);
            $lastRow = ['count' => $tempData->count(), 'last' => $tempData->last()];
        }
        $this->response->body(json_encode($lastRow));
        $this->autoRender = false;
        return $this->response;
    }
}
