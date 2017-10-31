<div class="container-fluid mercapp-page"  data-sidebar="others"> 

<?= $this->element('others') ?>

<div class="row mercapp-sub" id="mercapp-sub-2">

    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">Editar "<?= $state->name ?>"</h4>
            </div>
            <div class="content">
                <?= $this->Form->create($state) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->input('name', ['class' => 'form-control border-input', 'label' => 'Nombre <span>*</span>', "autofocus" => "autofocus"]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->input('country_id', ['options' => $countries, 'class' => 'form-control border-input', 'label' => 'País <span>*</span>', 'empty' => '-- Seleccione País --']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->control('active', ['class' => 'check-active border-input', 'label' => 'Activo?']) ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-info btn-fill btn-wd']) ?>
                        <?= $this->Html->link(__('Cancelar'), ['action' => 'add'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <?= $this->element('indexStates', ['states' => $states]) ?>

</div>

</div>