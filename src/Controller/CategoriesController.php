<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[] paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{

    public $paginate = [
        'limit' => 10,
        'contain' => ['ParentCategories']
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
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['ParentCategories', 'ChildCategories' => ['sort' => ['ChildCategories.name' => 'ASC']]]
        ]);

        $categories = $this->paginate($this->Categories);
        
        $this->set(compact('category', 'categories'));
        $this->set('_serialize', ['category', 'categories']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['slug'] = Inflector::slug($this->request->data['name']);
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $parentCategories = $this->Categories->ParentCategories->find('list', ['conditions' => ['ParentCategories.parent_id is null'], 'order' => ['ParentCategories.name' => 'ASC']]);

        $categories = $this->paginate($this->Categories);

        $this->set(compact('category', 'parentCategories', 'categories'));
        $this->set('_serialize', ['category', 'categories']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['slug'] = Inflector::slug($this->request->data['name']);
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('El registro fue guardado.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('El registro no fue guardado, por favor intentelo nuevamente.'));
        }
        $numberChildCategories = $this->Categories->ParentCategories->find('list', ['conditions' => ['ParentCategories.parent_id =' => $category->id]])->count();
        $parentCategories = [];
        if($numberChildCategories == 0){
            $parentCategories = $this->Categories->ParentCategories->find('list', ['conditions' => ['ParentCategories.parent_id is null', 'ParentCategories.id <>' => $category->id], ['order' => ['Countries.name' => 'ASC']]]);
        }

        $categories = $this->paginate($this->Categories);
        
        $this->set(compact('category', 'parentCategories', 'categories'));
        $this->set('_serialize', ['category', 'categories']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
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
            $tempData = $this->Categories->find()
                ->select(['total' => 'COUNT(*)', 'null' => 'COUNT(Categories.parent_id)'])->toArray();
            $countData[0] = ['main' => true, 'total' => $tempData[0]['total'] - $tempData[0]['null']];
            $countData[1] = ['main' => false, 'total' => $tempData[0]['null']];
        }
        $this->response->body(json_encode($countData));
        $this->autoRender = false;
        return $this->response;
    }
}
