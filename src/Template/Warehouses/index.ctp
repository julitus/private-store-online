<div class="container-fluid mercapp-page"  data-sidebar="products">

<div class="row mercapp-product">

    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Mis Productos&nbsp;
                    <?= $this->Html->link(__('<span class="ti-plus" aria-hidden="true"></span>'), ['controller' => 'products', 'action' => 'addItem'], ['class' => 'btn btn-simbol btn-success-inv', 'title' => 'Agregar', 'escape' => false]) ?>
                </h4>
            </div>
            <div class="content table-responsive">
                <?php if($warehouses->count()): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?= $this->Paginator->sort('product_id', 'Producto') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('price', 'Precio') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('stock', 'Stock') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('hit', 'Vistas') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('active', 'Estado') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created', 'Registrado') ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($warehouses as $key => $warehouse): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><?= h($warehouse->product->name) ?></td>
                            <td>
                                <?php if($warehouse->price == $warehouse->final_price): ?>
                                    <?= h($this->Number->format($warehouse->final_price, ['before' => '$', 'locale' => 'es_ES'])) ?>
                                <?php else: ?>
                                    <?= h($this->Number->format($warehouse->final_price, ['before' => '$', 'locale' => 'es_ES'])) . ' &nbsp;<strike><small>' . h($this->Number->format($warehouse->price, ['before' => '$', 'locale' => 'es_ES'])) . '</small></strike> &nbsp;<span class="text-success"><small>' . h($warehouse->discount) . '% dto.</small></span>' ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $warehouse->stock ?></td>
                            <td><?= h($warehouse->hit) ?></td>
                            <td>
                                <?= $warehouse->active ? '<span class="text-success"><small>Activo</small></span>' : '<span class="text-warning"><small>Inactivo</small></span>' ?>
                            </td>
                            <td><?= h(date($date_format, strtotime($warehouse->created))) ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('<span class="ti-reload" aria-hidden="true"></span>'), ['action' => 'active', $warehouse->id], ['class'=>'btn btn-simbol btn-success', 'title' => 'Activar/Desactivar', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $warehouse->id, $warehouse->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $warehouse->id, $warehouse->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $warehouse->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $warehouse->product->name), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
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
                        <p class="category">No hay productos registrados.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

</div>
