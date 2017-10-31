<?php 
    $getStoresStatsAdmin = $this->Url->build(['controller' => 'stores', 'action' => 'getLastRowAjax']);
    $getProductsStatsAdmin = $this->Url->build(['controller' => 'products', 'action' => 'getLastRowAjax']);
    $getProductsStatsStore = $this->Url->build(['controller' => 'warehouses', 'action' => 'getLastRowAjax']);
?>

<div class="container-fluid mercapp-page" data-sidebar="home"> 

<?php if($this->request->session()->read('Auth.User.role')): ?>

    <div class="row mercapp-dashboard-store">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-success text-center">
                                <i class="ti-truck"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Ordenes</p>
                                25
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-timer"></i> Ult. orden hace 2 horas
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card" id="products-stats-store" data-url="<?= $getProductsStatsStore ?>">
                <div class="content">
                    <?= $this->Html->link(
                        '<div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-danger text-center">
                                    <i class="ti-bag"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers numbers-sub">
                                    <p>Mis Productos</p>
                                    <span>0</span>
                                </div>
                            </div>
                        </div>', 
                        ['controller' => 'warehouses', 'action' => 'index'], ['escape' => false, 'title' => 'Mis productos registrados']) ?>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-calendar"></i>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-info text-center">
                                <i class="ti-comment"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Opiniones</p>
                                7
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-calendar"></i> Ult. opinion hace 2 dias
                        </div>
                    </div>
                </div>
            </div>
        </div-->
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <?= $this->Html->link(
                    '<div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-warning text-center">
                                <i class="ti-home"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Mi Tienda</p>
                                +
                            </div>
                        </div>
                    </div>', 
                    ['controller' => 'stores', 'action' => 'view', $this->request->session()->read('Auth.User.id'), $this->request->session()->read('Auth.User.slug')], ['escape' => false]) ?>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-more"></i> Ubicación, logo, etc
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <div class="row mercapp-dashboard-admin">
        <div class="col-lg-3 col-sm-6">
            <div class="card" id="stores-stats-admin" data-url="<?= $getStoresStatsAdmin ?>">
                <div class="content">
                    <?= $this->Html->link(
                        '<div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <i class="ti-medall-alt"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers numbers-sub">
                                    <p>Tiendas</p>
                                    <span>0</span>
                                </div>
                            </div>
                        </div>', 
                        ['controller' => 'stores', 'action' => 'index'], ['escape' => false, 'title' => 'Tiendas registradas']) ?>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-calendar"></i>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-success text-center">
                                <i class="ti-truck"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Ordenes</p>
                                25
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-timer"></i> Ult. orden hace 2 horas
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card" id="products-stats-admin" data-url="<?= $getProductsStatsAdmin ?>">
                <div class="content">
                    <?= $this->Html->link(
                        '<div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-danger text-center">
                                    <i class="ti-bag"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers numbers-sub">
                                    <p>Productos</p>
                                    <span>0</span>
                                </div>
                            </div>
                        </div>', 
                        ['controller' => 'products', 'action' => 'index'], ['escape' => false, 'title' => 'Productos registrados']) ?>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-calendar"></i>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <?= $this->Html->link(
                    '<div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-info text-center">
                                <i class="ti-pin-alt"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Otros</p>
                                +
                            </div>
                        </div>
                    </div>', 
                    ['controller' => 'categories', 'action' => 'add'], ['escape' => false]) ?>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-more"></i> Ubigeo, medidas, etc
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

</div>