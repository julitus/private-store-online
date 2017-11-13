<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[] paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{

    public function isAuthorized($store)
    {
        if (in_array($this->request->getParam('action'), ['getLastRowAjax'])) {
            return true;
        }
        // solo las tiendas
        if (in_array($this->request->getParam('action'), ['myIndex'])) {
            if (isset($store['role']) && $store['role'] === 1) {
                return true;
            } else {
                return false;
            }
        }
        // solo las tiendas y lo que les pertenece
        if (in_array($this->request->getParam('action'), ['delete'])) {
            $orderId = (int) $this->request->getParam('pass.0');
            if ($this->Orders->isOwnedBy($orderId, $store['id'])) {
                return true;
            } else {
                return false;
            }
        }
        // el administrador y cada tienda con sus ordenes
        if (in_array($this->request->getParam('action'), ['view'])) {
            $orderId = (int) $this->request->getParam('pass.0');
            if ($this->Orders->isOwnedBy($orderId, $store['id'])) {
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
                'Clients' => function($q) { 
                    return $q->select(['Clients.id', 'Clients.first_name', 'Clients.last_name']); 
                }, 
                'Stores' => function($q) { 
                    return $q->select(['Stores.id', 'Stores.name']); 
                }
            ],
            'order' => ['Orders.created' => 'desc']
        ];
        $orders = $this->paginate($this->Orders);

        $this->set('date_hour_format', Configure::read('DATE_HOUR_FORMAT'));
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }

    public function myIndex()
    {
        $this->paginate = [
            'contain' => [
                'Clients' => function($q) { 
                    return $q->select(['Clients.id', 'Clients.first_name', 'Clients.last_name']); 
                }
            ],
            'order' => ['Orders.created' => 'desc']
        ];
        $orders = $this->paginate($this->Orders->find()
                ->where(['Orders.store_id' => $this->Auth->user('id')])
            );

        $this->set('hour_format', Configure::read('HOUR_FORMAT'));
        $this->set('date_format', Configure::read('DATE_FORMAT'));
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [
                'Clients'  => function($q) { return $q->select(['Clients.id', 'Clients.first_name', 'Clients.last_name', 'Clients.email']); }, 
                'Stores' => function($q) { return $q->select(['Stores.id', 'Stores.name']); }, 
                'OrderDetails' => function($q) { 
                    return $q->contain([
                        'Warehouses' => function($r) {
                            return $r->select(['Warehouses.id', 'Warehouses.image', 'Warehouses.path'])
                                     ->contain(['Products.Measures']);
                        }
                    ]); 
                }
            ]
        ]);

        $order = $this->Orders->setBeforeOrder($order);

        $this->set('order', $order);
        $this->set('_serialize', ['order']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $clients = $this->Orders->Clients->find('list', ['limit' => 200]);
        $stores = $this->Orders->Stores->find('list', ['limit' => 200]);
        $this->set(compact('order', 'clients', 'stores'));
        $this->set('_serialize', ['order']);
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $clients = $this->Orders->Clients->find('list', ['limit' => 200]);
        $stores = $this->Orders->Stores->find('list', ['limit' => 200]);
        $this->set(compact('order', 'clients', 'stores'));
        $this->set('_serialize', ['order']);
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($order->status == 0) {
            if ($this->Orders->delete($order)) {
                $this->Flash->success(__('El registro fue eliminado.'));
            } else {
                $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
            }
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, aun no ha sido cancelado.'));
        }

        return $this->redirect(['action' => 'myIndex']);
    }

    public function getLastRowAjax()
    {
        $lastRow = [];
        if ($this->request->is('ajax')) {       
            if ($this->Auth->user('role') === 1) {
                $tempData = $this->Orders->find()
                    ->select(['Orders.id', 'Orders.created'])
                    ->where(['Orders.store_id' => $this->Auth->user('id')])
                    ->order(['Orders.id' => 'asc']);
                $lastRow = ['count' => $tempData->count(), 'last' => $tempData->last()];
            } else {
                $tempData = $this->Orders->find()
                    ->select(['Orders.id', 'Orders.created'])
                    ->order(['Orders.id' => 'asc']);
                $lastRow = ['count' => $tempData->count(), 'last' => $tempData->last()];
            }
        }
        $this->response->body(json_encode($lastRow));
        $this->autoRender = false;
        return $this->response;
    }
}
