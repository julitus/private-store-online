<?php 
    $getCategoriesStats = $this->Url->build(['controller' => 'Categories', 'action' => 'getCountDataAjax']);
    $getCountriesStats = $this->Url->build(['controller' => 'Countries', 'action' => 'getCountDataAjax']);
    $getStatesStats = $this->Url->build(['controller' => 'States', 'action' => 'getCountDataAjax']);
    $getProvincesStats = $this->Url->build(['controller' => 'Provinces', 'action' => 'getCountDataAjax']);
    $getMeasuresStats = $this->Url->build(['controller' => 'Measures', 'action' => 'getCountDataAjax']);
?>

<div class="row mercapp-others">
    <div class="col-lg-2 col-sm-4 col-custom">
        <div class="card" id="categories-stats" data-url="<?= $getCategoriesStats ?>">
            <div class="content">
                <?= $this->Html->link(
                    '<div class="row">
                        <div class="col-xs-2">
                            <div class="icon-small icon-warning text-center">
                                <i class="ti-tag"></i>
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <div class="numbers numbers-sub">
                                <p>Categorias</p>
                                <span>0</span>
                            </div>
                        </div>
                    </div>', 
                    ['controller' => 'categories', 'action' => 'add'], ['escape' => false, 'title' => 'Categorias y sub categorias para los productos']) ?>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-4 col-custom">
        <div class="card" id="countries-stats" data-url="<?= $getCountriesStats ?>">
            <div class="content">
                <?= $this->Html->link(
                    '<div class="row">
                        <div class="col-xs-2">
                            <div class="icon-small icon-info text-center">
                                <i class="ti-world"></i>
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <div class="numbers numbers-sub">
                                <p>Paises</p>
                                <span>0</span>
                            </div>
                        </div>
                    </div>', 
                    ['controller' => 'countries', 'action' => 'add'], ['escape' => false, 'title' => 'Paises de alcance']) ?>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-4 col-custom">
        <div class="card" id="states-stats" data-url="<?= $getStatesStats ?>">
            <div class="content">                
                <?= $this->Html->link(
                    '<div class="row">
                        <div class="col-xs-2">
                            <div class="icon-small icon-info text-center">
                                <i class="ti-map-alt"></i>
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <div class="numbers numbers-sub">
                                <p>Dptos.</p>
                                <span>0</span>
                            </div>
                        </div>
                    </div>', 
                    ['controller' => 'states', 'action' => 'add'], ['escape' => false, 'title' => 'Departamentos de alcance']) ?>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-4 col-custom">
        <div class="card" id="provinces-stats" data-url="<?= $getProvincesStats ?>">
            <div class="content">
                <?= $this->Html->link(
                    '<div class="row">
                        <div class="col-xs-2">
                            <div class="icon-small icon-info text-center">
                                <i class="ti-location-pin"></i>
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <div class="numbers numbers-sub">
                                <p>Ciudades</p>
                                <span>0</span>
                            </div>
                        </div>
                    </div>', 
                    ['controller' => 'provinces', 'action' => 'add'], ['escape' => false, 'title' => 'Ciudades de alcance']) ?>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-sm-4 col-custom">
        <div class="card" id="measures-stats" data-url="<?= $getMeasuresStats ?>">
            <div class="content">
                <?= $this->Html->link(
                    '<div class="row">
                        <div class="col-xs-2">
                            <div class="icon-small icon-danger text-center">
                                <i class="ti-ruler"></i>
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <div class="numbers numbers-sub">
                                <p>Medidas</p>
                                <span>0</span>
                            </div>
                        </div>
                    </div>', 
                    ['controller' => 'measures', 'action' => 'add'], ['escape' => false, 'title' => 'Configuracion de medidas, Kg, Lt, etc. para los produtos']) ?>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>