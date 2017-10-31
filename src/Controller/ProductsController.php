<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use Cake\Filesystem\Folder;
use Cake\Core\Configure;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[] paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

    public function isAuthorized($store)
    {
        if (in_array($this->request->getParam('action'), ['addItem', 'getProductsAjax'])) {
            if (isset($store['role']) && $store['role'] === 1) {
                return true;
            } else {
                return false;
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
            'contain' => ['Categories', 'Measures', 'Stores' => function($q) { return $q->select(['Stores.id', 'Stores.role', 'Stores.name']); }],
            'order' => [
                'Products.created' => 'desc'
            ]
        ];
        $products = $this->paginate($this->Products);

        $this->set('date_format', Configure::read('DATE_FORMAT'));
        $this->set(compact('products'));
        $this->set('_serialize', ['products']);
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Categories', 'Measures', 'Stores' => function($q) { return $q->select(['Stores.id', 'Stores.role', 'Stores.name']); }]
        ]);
        $product = $this->Products->setBeforeProduct($product);

        $this->paginate = [
            'contain' => [
                'Stores' => function ($q) {
                    return $q->select(['Stores.id', 'Stores.name']);
                }],
            'order' => [
                'Warehouses.Stores.name' => 'desc'
            ]
        ];
        $warehouses = $this->paginate($this->Products->Warehouses->find('all', [ 'conditions' => ['Warehouses.product_id =' => $product->id]]));

        $this->set(compact('product', 'warehouses'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['slug'] = Inflector::slug($this->request->data['name'] . ' ' . $this->request->data['measure_id'] . ' ' . $this->request->data['content']);
            $this->request->data['created_by'] = $this->Auth->user('id');

            if($this->request->data['picture']['name'] != ""){
                $folder = "/files/products/";
                $file = sha1(md5($this->request->data['name']));
                $picture = $file . substr($this->request->data['picture']['name'], -4);
                $this->request->data['image'] = $picture;
            }

            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($row = $this->Products->save($product)) {
                if($this->request->data['picture']['name'] != ""){
                    $folder .= $row['id'];
                    $this->Products->updateAll(['path' => $folder . DS], ['id' => $row['id']]);
                    $dir = new Folder(WWW_ROOT . $folder, true, 0775);
                    parent::moveUploadFile($this->request->data['picture']["tmp_name"], $folder . DS . $picture);
                }
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $categories = $this->Products->Categories->find('list', ['order' => ['Categories.name' => 'asc']]);
        $measures = $this->Products->Measures->find('list', ['order' => ['Measures.name' => 'asc']]);

        $this->set(compact('product', 'categories', 'measures'));
        $this->set('_serialize', ['product']);
    }

    public function addItem()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            debug($this->request->data);
            if ($this->request->data['is_new']) {
                $this->request->data['name'] = $this->request->data['name'][0];
                $this->request->data['slug'] = Inflector::slug($this->request->data['name'] . ' ' . $this->request->data['measure_id'] . ' ' . $this->request->data['content']);
                $this->request->data['created_by'] = $this->Auth->user('id');
                if($this->request->data['picture']['name'] != ""){
                    $folder = "/files/products/";
                    $file = sha1(md5($this->request->data['name']));
                    $picture = $file . substr($this->request->data['picture']['name'], -4);
                    $this->request->data['image'] = $picture;
                }

                $this->request->data['warehouses'][0]['store_id'] = $this->Auth->user('id');
                $this->request->data['warehouses'][0]['slug'] = Inflector::slug($this->request->data['name'] . ' ' . $this->Auth->user('id') . ' ' . $this->request->data['measure_id'] . ' ' . $this->request->data['content']);
                $this->request->data['warehouses'][0]['image'] = $picture;
                $product = $this->Products->patchEntity($product, $this->request->data, ['associated' => ['Warehouses']]);
                if ($row = $this->Products->save($product)) {
                    if($this->request->data['picture']['name'] != ""){
                        $folder .= $row['id'];
                        $this->Products->updateAll(['path' => $folder . DS], ['id' => $row['id']]);
                        $this->Products->Warehouses->updateAll(['path' => $folder . DS], ['id' => $row['warehouses'][0]['id']]);
                        $dir = new Folder(WWW_ROOT . $folder, true, 0775);
                        parent::moveUploadFile($this->request->data['picture']["tmp_name"], $folder . DS . $picture);
                    }
                    $this->Flash->success(__('El registro fue guardado.'));

                    return $this->redirect(['controller' => 'warehouses', 'action' => 'index']);
                } 
                $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
            } else {
                $warehouse = $this->Products->Warehouses->newEntity();
                $product = $this->Products->get($this->request->data['name'][0], ['contain' => []]);
                if($this->request->data['picture']['name'] != ""){
                    $folder = "/files/warehouses/";
                    $file = sha1(md5($product->name));
                    $picture = $file . substr($this->request->data['picture']['name'], -4);
                    $this->request->data['warehouses'][0]['image'] = $picture;
                } else {
                    $this->request->data['warehouses'][0]['image'] = $product->image;
                    $this->request->data['warehouses'][0]['path'] = $product->path;
                }

                $this->request->data['warehouses'][0]['product_id'] = $product->id;
                $this->request->data['warehouses'][0]['store_id'] = $this->Auth->user('id');
                $this->request->data['warehouses'][0]['slug'] = Inflector::slug($product->name . ' ' . $this->Auth->user('id') . ' ' . $this->request->data['measure_id'] . ' ' . $this->request->data['content']);
                $warehouse = $this->Products->Warehouses->patchEntity($warehouse, $this->request->data['warehouses'][0]);
                if ($row = $this->Products->Warehouses->save($warehouse)) {
                    if($this->request->data['picture']['name'] != ""){
                        $folder .= $row['id'];
                        $this->Products->Warehouses->updateAll(['path' => $folder . DS], ['id' => $row['id']]);
                        $dir = new Folder(WWW_ROOT . $folder, true, 0775);
                        parent::moveUploadFile($this->request->data['picture']["tmp_name"], $folder . DS . $picture);
                    }
                    $this->Flash->success(__('El registro fue guardado.'));

                    return $this->redirect(['controller' => 'warehouses', 'action' => 'index']);
                } 
                $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
            }
        }
        $categories = $this->Products->Categories->find('list', ['order' => ['Categories.name' => 'asc']]);
        $measures = $this->Products->Measures->find('list', ['order' => ['Measures.name' => 'asc']]);

        $this->set(compact('product', 'categories', 'measures'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['slug'] = Inflector::slug($this->request->data['name'] . ' ' . $this->request->data['measure_id'] . ' ' . $this->request->data['content']);

            if($this->request->data['picture']['name'] != ""){
                $folder = "/files/products/" . $id;
                $file = sha1(md5($this->request->data['name']));
                $picture = $file . substr($this->request->data['picture']['name'], -4);
                $this->request->data['path'] = $folder . DS;
                $this->request->data['image'] = $picture;
            }

            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                if($this->request->data['picture']['name'] != ""){
                    $dir = new Folder(WWW_ROOT . $folder, true, 0775);
                    parent::moveUploadFile($this->request->data['picture']["tmp_name"], $folder . DS . $picture);
                }

                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $categories = $this->Products->Categories->find('list', ['order' => ['Categories.name' => 'asc']]);
        $measures = $this->Products->Measures->find('list', ['order' => ['Measures.name' => 'asc']]);

        $this->set(compact('product', 'categories', 'measures'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('El registro fue eliminado'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getLastRowAjax()
    {
        $lastRow = [];
        if ($this->request->is('ajax')) {       
            $tempData = $this->Products->find()
                ->select(['Products.id', 'Products.created'])
                ->order(['Products.id' => 'asc']);
            $lastRow = ['count' => $tempData->count(), 'last' => $tempData->last()];
        }
        $this->response->body(json_encode($lastRow));
        $this->autoRender = false;
        return $this->response;
    }

    public function getProductsAjax()
    {
        $products = [];
        if ($this->request->is('ajax')) {
            $word = '%' . $this->request->query['search'] . '%';
            $products = $this->Products->find()
                ->where(['Products.name ILIKE' => $word])
                ->contain(['Measures']);
        }
        $this->response->body(json_encode($products));
        $this->autoRender = false;
        return $this->response;
    }
}
