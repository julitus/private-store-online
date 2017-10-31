<div class="container-fluid mercapp-page"  data-sidebar="products"> 

<div class="row mercapp-product">

	<?php 
	    $getProductsAjax = $this->Url->build(['controller' => 'products', 'action' => 'getProductsAjax']);
	    $no_image = $this->Url->build('/') . 'img/no-image.png';
	?>

	<div class="col-lg-12 col-md-12">
		<div class="card">
            <div class="header">
                <h4 class="title">Nuevo Producto</h4>
            </div>
            <div class="content">
            	<?= $this->Form->create($product, ['type' => 'file']) ?>
            		<div class="row">
                        <div class="col-md-8">
                        	<?= $this->Form->input('is_new', ['type' => 'hidden']) ?>
                        	<div class="input-product-ajax">
                            	<?= $this->Form->input('name', ['multiple' => 'multiple', 'type' => 'select', 'class' => 'form-control border-input', 'id' => 'product-ajax', 'onchange' => "checkNewProduct(this, '" . $no_image . "');", 'label' => 'Nombre <span>*</span>', 'data-ajax--url' => $getProductsAjax, 'data-app-url' => $this->Url->build('/')]) ?>
                            </div>
                            <div class="check-product-ajax">
                            	<i class="fa fa-circle-thin" id="product-ajax-check"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('category_id', ['options' => $categories, 'class' => 'form-control border-input selected-product', 'label' => 'Categoría <span>*</span>', 'empty' => '-- Seleccione Categoría --']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->Form->input('content', ['class' => 'form-control border-input selected-product', 'label' => 'Capacidad <span>*</span>', 'placeholder' => 'ej. 250,5']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('measure_id', ['options' => $measures, 'class' => 'form-control border-input selected-product', 'label' => 'Medida <span>*</span>', 'empty' => '-- Seleccione Medida --']) ?>
                        </div>
                        <div class="col-md-4">
                            <div class="image-sec">
                                <?= $this->Form->input('picture', ['id' => 'temp-input-image', 'class' => 'form-control border-input', 'label' => 'Imágen <span>*</span>', 'type'=>'file', 'accept'=>'image/*', 'onchange' => "loadImage(this, 'imgPhoto');"]) ?>
                            </div>
                            <div class="image-load">
                                <?= $this->Html->image('no-image.png', ['alt' => 'imagen', 'id' => 'imgPhoto']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-md-4">
                            <?= $this->Form->input('warehouses.0.price', ['class' => 'form-control border-input', 'label' => 'Precio <span>*</span>', 'placeholder' => 'ej. 2500,5']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('warehouses.0.discount', ['class' => 'form-control border-input', 'label' => 'Descuento(%) <span>*</span>', 'value' => '0']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('warehouses.0.stock', ['class' => 'form-control border-input', 'label' => 'Stock', 'value' => '0']) ?>
                        </div>
                    </div>
            	    <div class="text-center">
                        <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-info btn-fill btn-wd']) ?>
                        <?= $this->Html->link(__('Ir a Lista'), ['controller' => 'warehouses', 'action' => 'index'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
	</div>

</div>

</div>