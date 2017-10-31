<div class="col-lg-8 col-md-7">
    <div class="card">
        <div class="header">
            <h4 class="title">Categorias</h4>
        </div>
        <div class="content table-responsive">
            <?php if($categories->count()): ?>
            <table class="table table-hover">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col"><?= $this->Paginator->sort('name', 'Categoria') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('parent_id', 'Categoria Padre') ?></th>
                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                </thead>
                <tbody>
                    <?php foreach ($categories as $key => $category): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><?= h($category->name) ?></td>
                            <td><?= $category->has('parent_category') ? $category->parent_category->name : '--' ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $category->id, $category->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $category->id, $category->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $category->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $category->name), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <div class="header">
                  <ul class="pagination">
                    <?= $this->Paginator->first('&lsaquo;', ['escape' => false]) ?>
                    <?= $this->Paginator->prev('&laquo;', ['escape' => false]) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('&raquo;', ['escape' => false]) ?>
                    <?= $this->Paginator->last('&rsaquo;', ['escape' => false]) ?>
                  </ul>
                  <p class="category counter"><?= $this->Paginator->counter('Resultados {{start}} - {{end}} de {{count}}, página {{page}} / {{pages}}') ?></p>
              </div>
              <?php else: ?>
                <div class="header">
                    <p class="category">No hay categorias registradas.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>