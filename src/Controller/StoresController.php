<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use Cake\Filesystem\Folder;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Stores Controller
 *
 * @property \App\Model\Table\StoresTable $Stores
 *
 * @method \App\Model\Entity\Store[] paginate($object = null, array $settings = [])
 */
class StoresController extends AppController
{

    public $paginate = [
        'limit' => 20,
        'contain' => ['Provinces'],
        'order' => [
            'Stores.created' => 'desc'
        ]
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout']);
    }

    public function isAuthorized($store)
    {

        /*if (in_array($this->request->getParam('action'), ['edit', 'changePassword'])) {*/
        if (in_array($this->request->getParam('action'), ['changePassword'])) {
            $storeId = (int) $this->request->getParam('pass.0');
            if ($this->Stores->isOwnedBy($storeId, $store['id'])) {
                return true;
            } else {
                return false;
            }
        }

        if (in_array($this->request->getParam('action'), ['view', 'edit'])) {
            $storeId = (int) $this->request->getParam('pass.0');
            if ($this->Stores->isOwnedBy($storeId, $store['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($store);
    }

    public function index()
    {
        $stores = $this->paginate($this->Stores->find()->where(['Stores.role' => 1]));

        $this->set('date_format', Configure::read('DATE_FORMAT'));
        $this->set(compact('stores'));
        $this->set('_serialize', ['stores']);
    }

    public function view($id = null)
    {
        $store = $this->Stores->get($id, [
            'contain' => ['Countries', 'States', 'Provinces']
        ]);
        $store = $this->Stores->setBeforeStore($store);

        $this->set('store', $store);
        $this->set('_serialize', ['store']);
    }

    public function add()
    {
        $store = $this->Stores->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['token'] = sha1(md5($this->request->data['email']));
            $this->request->data['slug'] = Inflector::slug($this->request->data['name']);

            if($this->request->data['picture']['name'] != ""){
                $folder = "/files/stores/";
                $file = sha1(md5($this->request->data['email']));
                $picture = $file . substr($this->request->data['picture']['name'], -4);
                $this->request->data['image'] = $picture;
            }

            $store = $this->Stores->patchEntity($store, $this->request->getData());
            if ($row = $this->Stores->save($store)) {
                if($this->request->data['picture']['name'] != ""){
                    $folder .= $row['id'];
                    $this->Stores->updateAll(['path' => $folder . DS], ['id' => $row['id']]);
                    $dir = new Folder(WWW_ROOT . $folder, true, 0775);
                    parent::moveUploadFile($this->request->data['picture']["tmp_name"], $folder . DS . $picture);
                }

                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $countries = $this->Stores->Countries->find('list', ['conditions' => ['OR' => ['Countries.id =' => $store->country_id, 'Countries.active' => true]], 'order' => ['Countries.name' => 'ASC']]);
        $states = [];
        $provinces = [];

        $this->set(compact('store', 'countries', 'states', 'provinces'));
        $this->set('_serialize', ['store']);
    }

    public function edit($id = null)
    {
        $store = $this->Stores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['slug'] = Inflector::slug($this->request->data['name']);

            if($this->request->data['picture']['name'] != ""){
                $folder = "/files/stores/" . $id;
                $file = sha1(md5($this->request->data['email']));
                $picture = $file . substr($this->request->data['picture']['name'], -4);
                $this->request->data['path'] = $folder . DS;
                $this->request->data['image'] = $picture;
            }

            $store = $this->Stores->patchEntity($store, $this->request->getData());
            if ($this->Stores->save($store)) {
                if($this->request->data['picture']['name'] != ""){
                    $dir = new Folder(WWW_ROOT . $folder, true, 0775);
                    parent::moveUploadFile($this->request->data['picture']["tmp_name"], $folder . DS . $picture);
                    if ($id == $this->Auth->user('id')) {
                        $this->request->session()->write('Auth.User.path', $folder . DS);
                        $this->request->session()->write('Auth.User.image', $picture);
                    }
                }
                if ($id == $this->Auth->user('id')) {
                    $this->request->session()->write('Auth.User.name', $store->name);
                    $this->request->session()->write('Auth.User.slug', $store->slug);
                }

                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'view', $store->id, $store->slug]);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $countries = $this->Stores->Countries->find('list', ['conditions' => ['OR' => ['Countries.id =' => $store->country_id, 'Countries.active' => true]], 'order' => ['Countries.name' => 'ASC']]);
        $states = $this->Stores->States->find('list', ['conditions' => ['States.country_id =' => $store->country_id, 'States.active' => true], 'order' => ['States.name' => 'ASC']]);
        $provinces = $this->Stores->Provinces->find('list', ['conditions' => ['Provinces.state_id =' => $store->state_id, 'Provinces.active' => true], 'order' => ['Provinces.name' => 'ASC']]);

        $this->set(compact('store', 'countries', 'states', 'provinces'));
        $this->set('_serialize', ['store']);
    }

    public function changePassword($id = null)
    {
        $store = $this->Stores->get($id, [
            'contain' => ['Countries', 'States', 'Provinces']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $store = $this->Stores->patchEntity($store, $this->request->data);
            if ($this->Stores->save($store)) {
                $this->Flash->success(__('Contraseña cambiada con éxito.'));
                return $this->redirect(['action' => 'view', $store->id, $store->slug]);
            } else {
                $this->Flash->error(__('No se pudo cambiar la contraseña, por favor pruebe nuevamente.'));
            }
        }

        $this->set(compact('store'));
        $this->set('_serialize', ['store']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $store = $this->Stores->get($id);
        if ($this->Stores->delete($store)) {
            $this->Flash->success(__('El registro fue eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $store = $this->Auth->identify();
            if ($store) {
                if ($store['active']) {
                    $store['role_name'] = $store['role'] ? 'Tienda' : 'Administrador';
                    $this->Auth->setUser($store);
                    $this->Flash->success(__('Bienvenido. Esperamos disfrute de su estadia.'));
                    return $this->redirect(['controller' => 'pages', 'action' => 'dashboard']);
                    //return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__('El usuario no ha sido activado.'));    
                }
            } else {
                $this->Flash->error(__('Usuario o contraseña invalida, pruebe nuevamente.'));
            }
        }
        $this->viewBuilder()->setLayout('login');
    }

    public function logout()
    {
        $this->Flash->success(__('Hasta pronto.'));
        return $this->redirect($this->Auth->logout());
    }

    public function active($id = null)
    {
        $this->request->allowMethod(['post']);
        $store = $this->Stores->get($id);
        $store->active = !$store->active;
        if ($this->Stores->save($store)) {
            if ($store->active) {
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
            $tempData = $this->Stores->find()
                ->select(['Stores.id', 'Stores.created'])
                ->where(['Stores.role' => 1])
                ->order(['Stores.id' => 'asc']);
            $lastRow = ['count' => $tempData->count(), 'last' => $tempData->last()];
        }
        $this->response->body(json_encode($lastRow));
        $this->autoRender = false;
        return $this->response;
    }

}
