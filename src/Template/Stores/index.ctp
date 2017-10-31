<div class="container-fluid mercapp-page"  data-sidebar="stores">

<div class="row mercapp-store">

    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Tiendas&nbsp;
                    <?= $this->Html->link(__('<span class="ti-plus" aria-hidden="true"></span>'), ['action' => 'add'], ['class' => 'btn btn-simbol btn-success-inv', 'title' => 'Agregar', 'escape' => false]) ?>
                </h4>
            </div>
            <div class="content table-responsive">
                <?php if($stores->count()): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?= $this->Paginator->sort('name', 'Tienda') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('phone', 'Teléfono') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('province_id', 'Ciudad') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('active', 'Estado') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created', 'Registrado') ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stores as $key 
                        => $store): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><?= h($store->name) ?></td>
                            <td><?= h($store->phone != '' ? $store->phone : 'ninguno') ?></td>
                            <td><?= $store->has('province') ? $store->province->name : '--' ?></td>
                            <td>
                                <?= $store->active ? '<span class="text-success"><small>Activo</small></span>' : '<span class="text-warning"><small>Inactivo</small></span>' ?>
                            </td>
                            <td><?= h(date($date_format, strtotime($store->created))) ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('<span class="ti-reload" aria-hidden="true"></span>'), ['action' => 'active', $store->id], ['class'=>'btn btn-simbol btn-success', 'title' => 'Activar/Desactivar', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $store->id, $store->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $store->id, $store->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $store->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $store->name), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
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
                        <p class="category">No hay tiendas registradas.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

</div>