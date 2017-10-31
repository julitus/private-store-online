<div class="container-fluid mercapp-page"  data-sidebar="products"> 

<div class="row mercapp-product">

    <div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1">
        <div class="card">
            <div class="header">
                <h4 class="title">Editar Producto "<?= $product->name ?>"</h4>
            </div>
            <div class="content">
                <?= $this->Form->create($product, ['type' => 'file']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->input('name', ['class' => 'form-control border-input', 'label' => 'Nombre <span>*</span>', "autofocus" => "autofocus"]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('content', ['class' => 'form-control border-input', 'label' => 'Capacidad <span>*</span>', 'placeholder' => 'ej. 250,5']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('measure_id', ['options' => $measures, 'class' => 'form-control border-input', 'label' => 'Medida <span>*</span>', 'empty' => '-- Seleccione Medida --']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('category_id', ['options' => $categories, 'class' => 'form-control border-input', 'label' => 'Categoría <span>*</span>', 'empty' => '-- Seleccione Categoría --']) ?>
                        </div>
                        <div class="col-md-6">
                            <div class="image-sec">
                                <?= $this->Form->input('picture', ['class' => 'form-control border-input', 'label' => 'Imágen <span>*</span>', 'type'=>'file', 'accept'=>'image/*', 'onchange' => "loadImage(this, 'imgPhoto');"]) ?>
                            </div>
                            <div class="image-load">
                                <?php if($product['image'] == "" or is_null($product['image'])): ?>
                                  <?= $this->Html->image('no-image.png', ['alt' => 'imagen', 'id' => 'imgPhoto']) ?>
                                <?php else: ?>
                                  <?= $this->Html->image($product['path'] . $product['image'], ['alt' => 'imagen', 'id' => 'imgPhoto']) ?>
                                <?php endif; ?>
                            </div>
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