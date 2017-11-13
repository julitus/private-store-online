<div class="container-fluid mercapp-page"  data-sidebar="products">

<div class="row mercapp-product">

    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Productos&nbsp;
                    <?= $this->Html->link(__('<span class="ti-plus" aria-hidden="true"></span>'), ['action' => 'add'], ['class' => 'btn btn-simbol btn-success-inv', 'title' => 'Agregar', 'escape' => false]) ?>
                </h4>
            </div>
            <div class="content table-responsive">
                <?php if($products->count()): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?= $this->Paginator->sort('name', 'Producto') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('content', 'Capacidad') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('category_id', 'Categoría') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created_by', 'Creado por') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created', 'Registrado') ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $key => $product): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><?= h($product->name) ?></td>
                            <td><?= h($product->content) . ' ' . $product->measure->abrev ?></td>
                            <td><?= $product->has('category') ? $product->category->name : '--' ?></td>
                            <td><?= $product->has('store') ? h($product->store->name) . ($product->store->role ? '' : '<i class="fa fa-star-o admin-star"></i>') : '--' ?></td>
                            <td><?= h(date($date_format, strtotime($product->created))) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $product->id, $product->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $product->id, $product->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $product->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $product->name), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
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