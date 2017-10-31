<div class="container-fluid mercapp-page"  data-sidebar="others"> 

<?= $this->element('others') ?>

<div class="row mercapp-sub" id="mercapp-sub-2">

    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">Dpto.(<?= $state->name ?>)</h4>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $state->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>País</small></span><br>
                        <?= $state->country->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Estado</small></span><br>
                        <?= $state->active ? '<span class="text-success">Activo</span>' : '<span class="text-warning">Inactivo</span>' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Ciudades</small></span><br>
                        <?php if (!empty($state->provinces)): ?>
                        <table class="table-condensed">
                            <?php foreach ($state->provinces as $key => $province): ?>
                                <tr>
                                    <td><span class="text-success"><small><?= h($key +1) ?></small></span></td>
                                    <td><?= h($province->name) ?></td>
                                </tr>
                                <?php endforeach; ?>
                        </table>
                        <?php else: ?>
                            No tiene ciudades ingresadas.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center">
                    <?= $this->Html->link(__('Atras'), ['action' => 'add'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->element('indexStates', ['states' => $states]) ?>

</div>

</div>