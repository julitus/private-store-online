<div class="container-fluid mercapp-page"  data-sidebar="products"> 

<div class="row mercapp-product">

    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Producto(<?= $product->name ?>)&nbsp;
                    <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $product->id, $product->slug], ['class' => 'btn btn-simbol btn-success-inv', 'title' => 'Editar', 'escape' => false]) ?>
                </h4>
            </div>
            <div class="content content-image">
                <div class="row">
                    <div class="col-md-12">
                        <div class="image-image">
                            <?php if($product->image == "" or is_null($product->image)): ?>
                              <?= $this->Html->image('no-image.png', ['alt' => 'imagen']) ?>
                            <?php else: ?>
                              <?= $this->Html->image($product->path . $product->image, ['alt' => 'imagen']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $product->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Capacidad</small></span><br>
                        <?= h($this->Number->format($product->content)) . ' ' . $product->measure->abrev ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Categoría</small></span><br>
                        <?= $product->has('category') ? $product->category->name : '--' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Creado por</small></span><br>
                        <?= $product->store->name . ($product->store->role ? '' : '<i class="fa fa-star-o admin-star"></i>') ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Creado</small></span><br>
                        <?= $product->created_date ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Ult. Modificación</small></span><br>
                        <?= $product->modified_date ?>
                    </div>
                </div>
                <div class="text-center">
                    <?= $this->Html->link(__('Ir a Lista'), ['action' => 'index'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-7">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Tiendas que ofrecen este producto:
                </h4>
            </div>
            <div class="content table-responsive">
                <?php if($warehouses->count()): ?>
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col"><?= $this->Paginator->sort('store_id', 'Tienda') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('price', 'Precio') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('discount', 'Dto.') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('hit', '# de Vistas') ?></th>
                        <th scope="col" class="actions"><?= __('Acciones') ?></th>
                    </thead>
                    <tbody>
                        <?php foreach ($warehouses as $key => $warehouse): ?>
                            <tr>
                                <td><?= h($key + 1) ?></td>
                                <td><?= h($warehouse->store->name) ?></td>
                                <td><?= '$' . h($this->Number->format($warehouse->price)) ?></td>
                                <td><?= h($this->Number->format($warehouse->discount)) . '%' ?></td>
                                <td><?= h($warehouse->hit) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['controller' => 'warehouses', 'action' => 'view', $warehouse->id, $warehouse->slug], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
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
                        <p class="category">No hay tiendas vinculadas.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

</div>