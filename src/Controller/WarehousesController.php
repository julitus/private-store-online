<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use Cake\Filesystem\Folder;
use Cake\Core\Configure;
use CakeMonga\MongoCollection\CollectionRegistry;

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
        // solo las tiendas
        if (in_array($this->request->getParam('action'), ['index', 'getLastRowAjax'])) {
            if (isset($store['role']) && $store['role'] === 1) {
                return true;
            } else {
                return false;
            }
        }
        // solo las tiendas y lo que les pertenece
        if (in_array($this->request->getParam('action'), ['active', 'edit', 'delete'])) {
            $warehouseId = (int) $this->request->getParam('pass.0');
            if ($this->Warehouses->isOwnedBy($warehouseId, $store['id'])) {
                return true;
            } else {
                return false;
            }
        }
        // el administrador y cada tienda con su pertenencia
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
            'contain' => [
                'Products' => function($q) { 
                    return $q->contain(['Measures']); 
                }
            ],
            'order' => [
                'Warehouses.created' => 'desc'
            ]
        ];
        $warehouses = $this->paginate($this->Warehouses->find()
                    ->where(['Warehouses.store_id' => $this->Auth->user('id')])
                    ->select(['final_price' => 'price * ((100 - discount) / 100)'])
                    ->autoFields(true)
                );

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
                'Products' => function($q) { return $q->select(['Products.id', 'Products.name', 'Products.content', 'Products.category_id', 'Products.measure_id'])->contain(['Categories', 'Measures']); }, 
                'Stores' => function($q) { return $q->select(['Stores.id', 'Stores.role', 'Stores.name']); }
            ]
        ]);

        $warehouse = $this->Warehouses->setBeforeWarehouse($warehouse);

        $this->set('warehouse', $warehouse);
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
            'contain' => ['Products']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->data['picture']['name'] != ""){
                $folder = "/files/warehouses/" . $id;
                $file = sha1(md5($warehouse->product->name));
                $picture = $file . substr($this->request->data['picture']['name'], -4);
                $this->request->data['path'] = $folder . DS;
                $this->request->data['image'] = $picture;
            }

            $warehouse = $this->Warehouses->patchEntity($warehouse, $this->request->getData());
            if ($this->Warehouses->save($warehouse)) {
                if($this->request->data['picture']['name'] != ""){
                    $dir = new Folder(WWW_ROOT . $folder, true, 0775);
                    parent::moveUploadFile($this->request->data['picture']["tmp_name"], $folder . DS . $picture);
                }
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $categories = $this->Warehouses->Products->Categories->find('list', ['conditions' => ['Categories.id' => $warehouse->product->category_id]]);
        $measures = $this->Warehouses->Products->Measures->find('list', ['conditions' => ['Measures.id' => $warehouse->product->measure_id]]);

        $this->set(compact('warehouse', 'categories', 'measures'));
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
            $stores_collection = CollectionRegistry::get('Stores');
            $stores_collection->removeProductTo($warehouse);
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
            $stores_collection = CollectionRegistry::get('Stores');
            $stores_collection->changeActiveProductTo($warehouse);
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
