<div class="container-fluid mercapp-page"  data-sidebar="others"> 

<?= $this->element('others') ?>

<div class="row mercapp-sub" id="mercapp-sub-3">

    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">Ciudad(<?= $province->name ?>)</h4>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $province->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Departamento</small></span><br>
                        <?= $province->state->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Estado</small></span><br>
                        <?= $province->active ? '<span class="text-success">Activo</span>' : '<span class="text-warning">Inactivo</span>' ?>
                    </div>
                </div>
                <div class="text-center">
                    <?= $this->Html->link(__('Atras'), ['action' => 'add'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->element('indexProvinces', ['provinces' => $provinces]) ?>

</div>

</div>