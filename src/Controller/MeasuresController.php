<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Measures Controller
 *
 * @property \App\Model\Table\MeasuresTable $Measures
 *
 * @method \App\Model\Entity\Measure[] paginate($object = null, array $settings = [])
 */
class MeasuresController extends AppController
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
     * @param string|null $id Measure id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $measure = $this->Measures->get($id, [
            'contain' => []
        ]);

        $measures = $this->paginate($this->Measures);

        $this->set(compact('measure', 'measures'));
        $this->set('_serialize', ['measure', 'measures']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $measure = $this->Measures->newEntity();
        if ($this->request->is('post')) {
            $measure = $this->Measures->patchEntity($measure, $this->request->getData());
            if ($this->Measures->save($measure)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }

        $measures = $this->paginate($this->Measures);

        $this->set(compact('measure', 'measures'));
        $this->set('_serialize', ['measure', 'measures']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Measure id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $measure = $this->Measures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $measure = $this->Measures->patchEntity($measure, $this->request->getData());
            if ($this->Measures->save($measure)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        
        $measures = $this->paginate($this->Measures);

        $this->set(compact('measure', 'measures'));
        $this->set('_serialize', ['measure', 'measures']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Measure id.
     * @return \Cake\Http\Response|null Redirects to add.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $measure = $this->Measures->get($id);
        if ($this->Measures->delete($measure)) {
            $this->Flash->success(__('El registro fue eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el registro, es posible que tenga dependencias con otros registros.'));
        }

        return $this->redirect(['action' => 'add']);
    }

    public function getCountDataAjax()
    {
        $countData = [];
        if ($this->request->is('ajax')) {       
            $allData = $this->Measures->find()->count();
            $countData[0] = ['main' => true, 'total' => $allData];
        }
        $this->response->body(json_encode($countData));
        $this->autoRender = false;
        return $this->response;
    }
}
