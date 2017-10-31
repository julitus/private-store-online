<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Countries Controller
 *
 * @property \App\Model\Table\CountriesTable $Countries
 *
 * @method \App\Model\Entity\Country[] paginate($object = null, array $settings = [])
 */
class CountriesController extends AppController
{

    public $paginate = [
        'limit' => 10
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function isAuthorized($store)
    {
        return parent::isAuthorized($store);
    }

    /**
     * View method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $country = $this->Countries->get($id, [
            'contain' => ['States' => ['sort' => ['States.name' => 'ASC']]]
        ]);

        $countries = $this->paginate($this->Countries);

        $this->set(compact('country', 'countries'));
        $this->set('_serialize', ['country', 'countries']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $country = $this->Countries->newEntity();
        if ($this->request->is('post')) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }

        $countries = $this->paginate($this->Countries);

        $this->set(compact('country', 'countries'));
        $this->set('_serialize', ['country', 'countries']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $country = $this->Countries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            if ($this->Countries->save($country)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        
        $countries = $this->paginate($this->Countries);

        $this->set(compact('country', 'countries'));
        $this->set('_serialize', ['country', 'countries']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $country = $this->Countries->get($id);
        if ($this->Countries->delete($country)) {
            $this->Flash->success(__('El registro fue eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
        }

        return $this->redirect(['action' => 'add']);
    }

    public function active($id = null)
    {
        $this->request->allowMethod(['post']);
        $country = $this->Countries->get($id);
        $country->active = !$country->active;
        if ($this->Countries->save($country)) {
            if ($country->active) {
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
            $countData = $this->Countries->find()
                ->select(['main' => 'Countries.active', 'total' => 'COUNT(Countries.active)'])
                ->group(['Countries.active'])
                ->order(['main' => 'DESC']);
        }
        $this->response->body(json_encode($countData));
        $this->autoRender = false;
        return $this->response;
    }
}