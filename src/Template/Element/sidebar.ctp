<div class="sidebar" data-background-color="black" data-active-color="success">
<!--
	Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
	Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
-->
	<div class="sidebar-wrapper">
        <div class="logo">            
            <?= $this->Html->image('mercappv2.png', ['url' => ['controller' => 'pages', 'action' => 'dashboard']]); ?>
        </div>

        <ul class="nav">
            <?php if($this->request->session()->read('Auth.User.role')): ?>
                <li class="mercapp-sidebar" id="sidebar-home">
                    <?= $this->Html->link('<i class="ti-panel"></i><p>Inicio</p>', ['controller' => 'pages', 'action' => 'dashboard'], ['escape' => false]) ?>
                </li>
                <li class="mercapp-sidebar" id="sidebar-stores">
                    <?= $this->Html->link('<i class="ti-home"></i><p>Mi Tienda</p>', ['controller' => 'stores', 'action' => 'view', $this->request->session()->read('Auth.User.id'), $this->request->session()->read('Auth.User.slug')], ['escape' => false]) ?>
                </li>
                <li class="mercapp-sidebar" id="sidebar-orders">
                    <?= $this->Html->link('<i class="ti-truck"></i><p>Ordenes</p>', ['controller' => 'orders', 'action' => 'myIndex'], ['escape' => false]) ?>
                </li>
                <li class="mercapp-sidebar" id="sidebar-products">
                    <?= $this->Html->link('<i class="ti-bag"></i><p>Productos</p>', ['controller' => 'warehouses', 'action' => 'index'], ['escape' => false]) ?>
                </li>
            <?php else: ?>
                <li class="mercapp-sidebar" id="sidebar-home">
                    <?= $this->Html->link('<i class="ti-home"></i><p>Inicio</p>', ['controller' => 'pages', 'action' => 'dashboard'], ['escape' => false]) ?>
                </li>
                <li class="mercapp-sidebar" id="sidebar-stores">
                    <?= $this->Html->link('<i class="ti-medall-alt"></i><p>Tiendas</p>', ['controller' => 'stores', 'action' => 'index'], ['escape' => false]) ?>
                </li>
                <li class="mercapp-sidebar" id="sidebar-orders">
                    <?= $this->Html->link('<i class="ti-truck"></i><p>Ordenes</p>', ['controller' => 'orders', 'action' => 'index'], ['escape' => false]) ?>
                </li>
                <li class="mercapp-sidebar" id="sidebar-products">
                    <?= $this->Html->link('<i class="ti-bag"></i><p>Productos</p>', ['controller' => 'products', 'action' => 'index'], ['escape' => false]) ?>
                </li>
                <li class="mercapp-sidebar" id="sidebar-others">
                    <?= $this->Html->link('<i class="ti-pin-alt"></i><p>Otros</p>', ['controller' => 'categories', 'action' => 'add'], ['escape' => false]) ?>
                </li>
            <?php endif; ?>
            
			<li class="active-pro">
                <?= $this->Html->link('<i class="ti-back-left"></i><p>Cerrar Sesión</p>', ['controller' => 'stores', 'action' => 'logout'], ['escape' => false]) ?>
            </li>
        </ul>
	</div>
</div>