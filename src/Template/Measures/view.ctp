<div class="container-fluid mercapp-page"  data-sidebar="others"> 

<?= $this->element('others') ?>

<div class="row mercapp-sub" id="mercapp-sub-4">

    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">Medida(<?= $measure->name ?>)</h4>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $measure->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Abreviatura</small></span><br>
                        <?= $measure->abrev ?>
                    </div>
                </div>
                <div class="text-center">
                    <?= $this->Html->link(__('Atras'), ['action' => 'add'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->element('indexMeasures', ['measures' => $measures]) ?>

</div>

</div>