<div class="col-lg-8 col-md-7">
    <div class="card">
        <div class="header">
            <h4 class="title">Departamentos</h4>
        </div>
        <div class="content table-responsive">
            <?php if($states->count()): ?>
            <table class="table table-hover">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col"><?= $this->Paginator->sort('name', 'Departamento') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('country_id', 'País') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('active', 'Estado') ?></th>
                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                </thead>
                <tbody>
                    <?php foreach ($states as $key => $state): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><?= h($state->name) ?></td>
                            <td><?= $state->has('country') ? $state->country->name : '--' ?></td>
                            <td>
                                <?= $state->active ? '<span class="text-success"><small>Activo</small></span>' : '<span class="text-warning"><small>Inactivo</small></span>' ?>
                            </td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('<span class="ti-reload" aria-hidden="true"></span>'), ['action' => 'active', $state->id], ['class'=>'btn btn-simbol btn-success', 'title' => 'Activar/Desactivar', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $state->id], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $state->id], ['class' => 'btn btn-simbol btn-success', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $state->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $state->name), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
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
                    <p class="category">No hay departamentos registrados.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>