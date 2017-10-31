<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Provinces Controller
 *
 * @property \App\Model\Table\ProvincesTable $Provinces
 *
 * @method \App\Model\Entity\Province[] paginate($object = null, array $settings = [])
 */
class ProvincesController extends AppController
{

    public $paginate = [
        'limit' => 10,
        'contain' => ['States']
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function isAuthorized($store)
    {
        if (in_array($this->request->getParam('action'), ['getListActiveAjax'])) {
            return true;
        }
        return parent::isAuthorized($store);
    }

    /**
     * View method
     *
     * @param string|null $id Province id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $province = $this->Provinces->get($id, [
            'contain' => ['States']
        ]);

        $provinces = $this->paginate($this->Provinces);

        $this->set(compact('province', 'provinces'));
        $this->set('_serialize', ['province', 'provinces']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $province = $this->Provinces->newEntity();
        if ($this->request->is('post')) {
            $province = $this->Provinces->patchEntity($province, $this->request->getData());
            if ($this->Provinces->save($province)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }

        $states = $this->Provinces->States->find('list', ['order' => ['States.name' => 'ASC']]);
        $provinces = $this->paginate($this->Provinces);

        $this->set(compact('province', 'states', 'provinces'));
        $this->set('_serialize', ['province', 'provinces']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Province id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $province = $this->Provinces->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $province = $this->Provinces->patchEntity($province, $this->request->getData());
            if ($this->Provinces->save($province)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $states = $this->Provinces->States->find('list', ['order' => ['States.name' => 'ASC']]);
        $provinces = $this->paginate($this->Provinces);

        $this->set(compact('province', 'states', 'provinces'));
        $this->set('_serialize', ['province', 'provinces']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Province id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $province = $this->Provinces->get($id);
        if ($this->Provinces->delete($province)) {
            $this->Flash->success(__('El registro fue eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
        }

        return $this->redirect(['action' => 'add']);
    }

    public function active($id = null)
    {
        $this->request->allowMethod(['post']);
        $province = $this->Provinces->get($id);
        $province->active = !$province->active;
        if ($this->Provinces->save($province)) {
            if ($province->active) {
                $this->Flash->success(__('El registro fue activado.'));
            } else {
                $this->Flash->success(__('El registro fue desactivado.'));
            }
        } else {
            $this->Flash->error(__('No se pudo cambiar el estado, por favor intentelo nuevamente.'));
        }

        return $this->redirect($this->referer());
    }

    public function getCountDataAjax()
    {
        $countData = [];
        if ($this->request->is('ajax')) {       
            $countData = $this->Provinces->find()
                ->select(['main' => 'Provinces.active', 'total' => 'COUNT(Provinces.active)'])
                ->group(['Provinces.active'])
                ->order(['main' => 'DESC']);
        }
        $this->response->body(json_encode($countData));
        $this->autoRender = false;
        return $this->response;
    }

    public function getListActiveAjax()
    {
        $data = [];
        if ($this->request->is('ajax')) {       
            $data = $this->Provinces->find('list', ['conditions' => ['Provinces.state_id =' => $this->request->data['state_id'], 'Provinces.active' => true], 'order' => ['Provinces.name' => 'ASC']]);
        }
        $this->response->body(json_encode($data));
        $this->autoRender = false;
        return $this->response;
    }
}
