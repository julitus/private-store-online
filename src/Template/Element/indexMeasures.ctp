<div class="col-lg-8 col-md-7">
    <div class="card">
        <div class="header">
            <h4 class="title">Medidas</h4>
        </div>
        <div class="content table-responsive">
            <?php if($measures->count()): ?>
            <table class="table table-hover">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col"><?= $this->Paginator->sort('name', 'Medida') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('abrev', 'Abreviatura') ?></th>
                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                </thead>
                <tbody>
                    <?php foreach ($measures as $key => $measure): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><?= h($measure->name) ?></td>
                            <td><?= h($measure->abrev) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $measure->id], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $measure->id], ['class' => 'btn btn-simbol btn-success', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $measure->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $measure->name), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
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
                    <p class="category">No hay medidas registradas.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>