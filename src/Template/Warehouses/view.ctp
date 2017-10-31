<div class="container-fluid mercapp-page"  data-sidebar="products"> 

<div class="row mercapp-product">

    <div class="col-lg-4 col-md-6 col-lg-offset-4 col-md-offset-3">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Producto(<?= $warehouse->product->name ?>)&nbsp;
                    <?php if($this->request->session()->read('Auth.User.id') == $warehouse->store->id): ?>
                        <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $warehouse->id, $warehouse->slug], ['class' => 'btn btn-simbol btn-success-inv', 'title' => 'Editar', 'escape' => false]) ?>
                    <?php endif; ?>
                </h4>
            </div>
            <div class="content content-image">
                <div class="row">
                    <div class="col-md-12">
                        <div class="image-image">
                            <?php if($warehouse->image == "" or is_null($warehouse->image)): ?>
                              <?= $this->Html->image('no-image.png', ['alt' => 'imagen']) ?>
                            <?php else: ?>
                              <?= $this->Html->image($warehouse->path . $warehouse->image, ['alt' => 'imagen']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $warehouse->product->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Capacidad</small></span><br>
                        <?= h($warehouse->product->content) . ' ' . $warehouse->product->measure->abrev ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Precio</small></span><br>
                        <?php if($warehouse->price == $warehouse->final_price): ?>
                                    <?= h($this->Number->format($warehouse->final_price, ['before' => '$', 'locale' => 'es_ES'])) ?>
                        <?php else: ?>
                            <?= h($this->Number->format($warehouse->final_price, ['before' => '$', 'locale' => 'es_ES'])) . ' &nbsp;<strike><small>' . h($this->Number->format($warehouse->price, ['before' => '$', 'locale' => 'es_ES'])) . '</small></strike> &nbsp;<span class="text-success"><small>' . h($warehouse->discount) . '% dto.</small></span>' ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Stock</small></span><br>
                        <?= $warehouse->stock ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Categoría</small></span><br>
                        <?= $warehouse->product->has('category') ? $warehouse->product->category->name : '--' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Tienda</small></span><br>
                        <?= $warehouse->store->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Estado</small></span><br>
                        <?= $warehouse->active ? '<span class="text-success">Activo</span>' : '<span class="text-warning">Inactivo</span>' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Visualizaciones</small></span><br>
                        <?= $warehouse->hit ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Creado</small></span><br>
                        <?= $warehouse->created_date ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Ult. Modificación</small></span><br>
                        <?= $warehouse->modified_date ?>
                    </div>
                </div>
                <div class="text-center">
                    <?php if($this->request->session()->read('Auth.User.id') == $warehouse->store->id): ?>
                        <?= $this->Html->link(__('Ir a Lista'), ['action' => 'index'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                    <?php else: ?>
                        <a href="javascript:history.back()" class="btn btn-warning btn-fill btn-wd">Atrás</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

</div>