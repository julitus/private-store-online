<div class="container-fluid mercapp-page"  data-sidebar="products"> 

<div class="row mercapp-product">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Editar Producto "<?= $warehouse->product->name ?>"</h4>
            </div>
            <div class="content">
                <?= $this->Form->create($warehouse, ['type' => 'file']) ?>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $this->Form->input('product.name', ['class' => 'form-control border-input', 'label' => 'Nombre <span>*</span>', 'readonly' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('product.category_id', ['options' => $categories, 'class' => 'form-control border-input selected-product', 'label' => 'Categoría <span>*</span>', 'readonly' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->Form->input('product.content', ['class' => 'form-control border-input selected-product', 'label' => 'Capacidad <span>*</span>', 'placeholder' => 'ej. 250,5', 'readonly' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('product.measure_id', ['options' => $measures, 'class' => 'form-control border-input selected-product', 'label' => 'Medida <span>*</span>', 'readonly' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <div class="image-sec">
                                <?= $this->Form->input('picture', ['class' => 'form-control border-input', 'label' => 'Imágen <span>*</span>', 'type'=>'file', 'accept'=>'image/*', 'onchange' => "loadImage(this, 'imgPhoto');"]) ?>
                            </div>
                            <div class="image-load">
                                <?php if($warehouse['image'] == "" or is_null($warehouse['image'])): ?>
                                  <?= $this->Html->image('no-image.png', ['alt' => 'imagen', 'id' => 'imgPhoto']) ?>
                                <?php else: ?>
                                  <?= $this->Html->image($warehouse['path'] . $warehouse['image'], ['alt' => 'imagen', 'id' => 'imgPhoto']) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->Form->input('price', ['class' => 'form-control border-input', 'label' => 'Precio <span>*</span>', 'placeholder' => 'ej. 2500,5']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('discount', ['class' => 'form-control border-input', 'label' => 'Descuento(%) <span>*</span>']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('stock', ['class' => 'form-control border-input', 'label' => 'Stock']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->control('active', ['class' => 'check-active border-input', 'label' => 'Activo?']) ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-info btn-fill btn-wd']) ?>
                        <?= $this->Html->link(__('Ir a Lista'), ['action' => 'index'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</div>

</div>