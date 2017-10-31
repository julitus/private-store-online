<div class="container-fluid mercapp-page" data-sidebar="password"> 

<div class="row mercapp-store">

    <div class="col-lg-4 col-md-6 col-lg-offset-4 col-md-offset-3">
        <div class="card">
            <div class="header">
                <h4 class="title">Cambiar mi contraseña</h4>
            </div>
            <div class="content ">
                <?= $this->Form->create($store) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->input('password', ['class' => 'form-control border-input', 'label' => 'Contraseña <span>*</span>', "autofocus" => "autofocus", 'value' => '']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->input('re_password', ['class' => 'form-control border-input', 'label' => 'Confirmar Contraseña <span>*</span>', 'type' => 'password', 'value' => '']) ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-info btn-fill btn-wd']) ?>
                        <?= $this->Html->link(__('Cancelar'), ['action' => 'view', $store->id, $store->slug], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</div>

</div>