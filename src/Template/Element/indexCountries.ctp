<div class="col-lg-8 col-md-7">
    <div class="card">
        <div class="header">
            <h4 class="title">Paises</h4>
        </div>
        <div class="content table-responsive">
            <?php if($countries->count()): ?>
            <table class="table table-hover">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col"><?= $this->Paginator->sort('name', 'País') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('sortname', 'Abreviatura') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('active', 'Estado') ?></th>
                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                </thead>
                <tbody>
                    <?php foreach ($countries as $key => $country): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><?= h($country->name) ?></td>
                            <td><?= h($country->sortname) ?></td>
                            <td>
                                <?= $country->active ? '<span class="text-success"><small>Activo</small></span>' : '<span class="text-warning"><small>Inactivo</small></span>' ?>
                            </td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('<span class="ti-reload" aria-hidden="true"></span>'), ['action' => 'active', $country->id], ['class'=>'btn btn-simbol btn-success', 'title' => 'Activar/Desactivar', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $country->id], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $country->id], ['class' => 'btn btn-simbol btn-success', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $country->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $country->name), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
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
                    <p class="category">No hay paises registrados.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>