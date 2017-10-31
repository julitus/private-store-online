<div class="container-fluid mercapp-page"  data-sidebar="others"> 

<?= $this->element('others') ?>

<div class="row mercapp-sub" id="mercapp-sub-1">

    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">País(<?= $country->name ?>)</h4>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $country->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Abreviatura</small></span><br>
                        <?= $country->sortname ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Estado</small></span><br>
                        <?= $country->active ? '<span class="text-success">Activo</span>' : '<span class="text-warning">Inactivo</span>' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Departamentos</small></span><br>
                        <?php if (!empty($country->states)): ?>
                        <table class="table-condensed">
                            <?php foreach ($country->states as $key => $state): ?>
                                <tr>
                                    <td><span class="text-success"><small><?= h($key +1) ?></small></span></td>
                                    <td><?= h($state->name) ?></td>
                                </tr>
                                <?php endforeach; ?>
                        </table>
                        <?php else: ?>
                            No tiene departamentos ingresados.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center">
                    <?= $this->Html->link(__('Atras'), ['action' => 'add'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->element('indexCountries', ['countries' => $countries]) ?>

</div>

</div>