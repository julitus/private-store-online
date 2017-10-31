<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * States Controller
 *
 * @property \App\Model\Table\StatesTable $States
 *
 * @method \App\Model\Entity\State[] paginate($object = null, array $settings = [])
 */
class StatesController extends AppController
{

    public $paginate = [
        'limit' => 10,
        'contain' => ['Countries']
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
     * @param string|null $id State id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $state = $this->States->get($id, [
            'contain' => ['Countries', 'Provinces' => ['sort' => ['Provinces.name' => 'ASC']]]
        ]);

        $states = $this->paginate($this->States);

        $this->set(compact('state', 'states'));
        $this->set('_serialize', ['state', 'states']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $state = $this->States->newEntity();
        if ($this->request->is('post')) {
            $state = $this->States->patchEntity($state, $this->request->getData());
            if ($this->States->save($state)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }

        $countries = $this->States->Countries->find('list', ['order' => ['Countries.name' => 'ASC']]);
        $states = $this->paginate($this->States);

        $this->set(compact('state', 'countries', 'states'));
        $this->set('_serialize', ['state', 'states']);
    }

    /**
     * Edit method
     *
     * @param string|null $id State id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $state = $this->States->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $state = $this->States->patchEntity($state, $this->request->getData());
            if ($this->States->save($state)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }

        $countries = $this->States->Countries->find('list', ['order' => ['Countries.name' => 'ASC']]);
        $states = $this->paginate($this->States);

        $this->set(compact('state', 'countries', 'states'));
        $this->set('_serialize', ['state', 'states']);
    }

    /**
     * Delete method
     *
     * @param string|null $id State id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $state = $this->States->get($id);
        if ($this->States->delete($state)) {
            $this->Flash->success(__('El registro fue eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
        }

        return $this->redirect(['action' => 'add']);
    }

    public function active($id = null)
    {
        $this->request->allowMethod(['post']);
        $state = $this->States->get($id);
        $state->active = !$state->active;
        if ($this->States->save($state)) {
            if ($state->active) {
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
            $countData = $this->States->find()
                ->select(['main' => 'States.active', 'total' => 'COUNT(States.active)'])
                ->group(['States.active'])
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
            $data = $this->States->find('list', ['conditions' => ['States.country_id =' => $this->request->data['country_id'], 'States.active' => true], 'order' => ['States.name' => 'ASC']]);
        }
        $this->response->body(json_encode($data));
        $this->autoRender = false;
        return $this->response;
    }
}
