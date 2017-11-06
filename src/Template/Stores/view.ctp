<div class="container-fluid mercapp-page"  data-sidebar="stores"> 

<div class="row mercapp-store">

    <?php 
        if($store->image != '' and !is_null($store->image)) {
            $image = $this->Html->image($store->path . $store->image, ['url' => ['controller' => 'stores', 'action' => 'view', $store->id, $store->slug]]);
        } else {
            $image = $this->Html->image('no-store.png', ['url' => ['controller' => 'stores', 'action' => 'view', $store->id, $store->slug]]);
        }
    ?>
    
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Tienda(<?= $store->name ?>)&nbsp;
                    <?php //if($this->request->session()->read('Auth.User.id') == $store->id): ?>
                        <?= $this->Html->link(__('<span class="ti-pencil" aria-hidden="true"></span>'), ['action' => 'edit', $store->id, $store->slug], ['class' => 'btn btn-simbol btn-success-inv', 'title' => 'Editar', 'escape' => false]) ?>
                    <?php //endif; ?>
                </h4>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $store->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Descripción</small></span><br>
                        <?= $store->description != '' ? $this->Text->autoParagraph($store->description) : 'ninguna' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Correo Electrónico</small></span><br>
                        <?= $store->email ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Rol</small></span><br>
                        <?= '<span class="text-info">' . $store->role_name . '</span>' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Dirección</small></span><br>
                        <?= $store->address != '' ? $store->address : 'ninguna' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Teléfono</small></span><br>
                        <?= $store->phone != '' ? $store->phone : 'ninguno'?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Contacto</small></span><br>
                        <?= $store->contact != '' ? $store->contact : 'sin asignar'?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>País</small></span><br>
                        <?= $store->has('country') ? $store->country->name : '--' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Departamento</small></span><br>
                        <?= $store->has('state') ? $store->state->name : '--' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Ciudad</small></span><br>
                        <?= $store->has('province') ? $store->province->name : '--' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Localización</small></span><br>
                        <span class="text-success"><small>lat:</small></span> <?= $store->latitude ?><br>
                        <span class="text-success"><small>lng:</small></span> <?= $store->longitude ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Estado</small></span><br>
                        <?= $store->active ? '<span class="text-success">Activo</span>' : '<span class="text-warning">Inactivo</span>' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Visualizaciones</small></span><br>
                        <?= $store->hit ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Calificación</small></span><br>
                        <?= $store->rating != '' ? $store->rating : 'sin evaluar' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Creado</small></span><br>
                        <?= $store->created_date ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Ult. Modificación</small></span><br>
                        <?= $store->modified_date ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7">
        <div class="card card-map">
            <div class="content content-logo">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="image-logo">
                            <?php if($store->image == "" or is_null($store->image)): ?>
                              <?= $this->Html->image('no-image.png', ['alt' => 'imagen']) ?>
                            <?php else: ?>
                              <?= $this->Html->image($store->path . $store->image, ['alt' => 'imagen']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header">
                <h4 class="title">Ubicación</h4>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="map">
                            <?php $store->description = $this->Text->autoParagraph($store->description) ?>
                            <div id="map" data-store='<?= $store ?>' data-url-image='<?= $image ?>' ></div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <?php if($this->request->session()->read('Auth.User.id') != $store->id): ?>
                        <?= $this->Html->link(__('Ir a Lista'), ['action' => 'index'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

</div>