<div class="container-fluid mercapp-page"  data-sidebar="stores"> 

<div class="row mercapp-store">

    <?php 
        $getStates = $this->Url->build(['controller' => 'States', 'action' => 'getListActiveAjax']);
        $getProvinces = $this->Url->build(['controller' => 'Provinces', 'action' => 'getListActiveAjax']);
    ?>

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Editar Tienda "<?= $store->name ?>"</h4>
            </div>
            <div class="content ">
                <?= $this->Form->create($store, ['type' => 'file']) ?>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->Form->input('name', ['class' => 'form-control border-input', 'label' => 'Nombre <span>*</span>', "autofocus" => "autofocus"]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('email', ['class' => 'form-control border-input', 'label' => 'Correo electrónico <span>*</span>', 'readonly' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('contact', ['class' => 'form-control border-input', 'label' => 'Contacto']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->Form->input('address', ['class' => 'form-control border-input', 'label' => 'Dirección']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('phone', ['class' => 'form-control border-input', 'label' => 'Teléfono']) ?>
                        </div>
                        <div class="col-md-4">
                            <div class="image-sec">
                                <?= $this->Form->input('picture', ['class' => 'form-control border-input', 'label' => 'Logo', 'type'=>'file', 'accept'=>'image/*', 'onchange' => "loadImage(this, 'imgPhoto');"]) ?>
                            </div>
                            <div class="image-load">
                                <?php if($store['image'] == "" or is_null($store['image'])): ?>
                                  <?= $this->Html->image('no-image.png', ['alt' => 'imagen', 'id' => 'imgPhoto']) ?>
                                <?php else: ?>
                                  <?= $this->Html->image($store['path'] . $store['image'], ['alt' => 'imagen', 'id' => 'imgPhoto']) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->Form->input('country_id', ['options' => $countries, 'class' => 'form-control border-input', 'label' => 'País', 'empty' => '-- Seleccione País --', 'onchange'=>"getStates('$getStates', '');"]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('state_id', ['options' => $states, 'class' => 'form-control border-input', 'label' => 'Departamento', 'empty' => '-- Seleccione Dpto. --', 'onchange'=>"getProvinces('$getProvinces', '');"]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('province_id', ['options' => $provinces, 'class' => 'form-control border-input', 'label' => 'Ciudad', 'empty' => '-- Seleccione Ciudad --']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->input('description', ['class' => 'form-control border-input', 'label' => 'Descripción', 'placeholder' => 'Describe aqui tu tienda, horario de atención o un slogan.', 'rows' => 5]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->control('active', ['class' => 'check-active border-input', 'label' => 'Activo?']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <?= $this->Form->input('latitude', ['class' => 'form-control border-input', 'label' => 'Latitud', 'readonly' => true]) ?>
                        </div>
                        <div class="col-xs-6">
                            <?= $this->Form->input('longitude', ['class' => 'form-control border-input', 'label' => 'Longitud', 'readonly' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="map-edit">
                                <div id="floating-panel" class="float-panel">
                                    <input id="map-address" type="textbox" placeholder="6.239933,-75.567310">
                                    <input id="map-search" type="button" value="Buscar">
                                </div>
                                <div id="map-location" data-store='<?= $store ?>' ></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-info btn-fill btn-wd']) ?>
                        <?php if($this->request->session()->read('Auth.User.id') == $store->id): ?>
                            <?= $this->Html->link(__('Cancelar'), ['action' => 'view', $store->id, $store->slug], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                        <?php else: ?>
                            <?= $this->Html->link(__('Ir a Lista'), ['action' => 'index'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                        <?php endif; ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</div>

</div>