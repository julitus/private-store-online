<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <?php if($this->request->session()->read('Auth.User.image') != '' and !is_null($this->request->session()->read('Auth.User.image'))): ?>
                <?= $this->Html->image($this->request->session()->read('Auth.User.path').$this->request->session()->read('Auth.User.image'), ['url' => ['controller' => 'stores', 'action' => 'view', $this->request->session()->read('Auth.User.id'), $this->request->session()->read('Auth.User.slug')]]); ?>
            <?php else: ?>
                <?= $this->Html->image('no-store.png', ['url' => ['controller' => 'stores', 'action' => 'view', $this->request->session()->read('Auth.User.id'), $this->request->session()->read('Auth.User.slug')]]); ?>
            <?php endif; ?>
            <?= $this->Html->link($this->request->session()->read('Auth.User.name') . '<br><label>' . $this->request->session()->read('Auth.User.role_name') . ($this->request->session()->read('Auth.User.role') ? '' : '<i class="fa fa-star-o admin-star"></i>') . '</label>', ['controller' => 'stores', 'action' => 'view', $this->request->session()->read('Auth.User.id'), $this->request->session()->read('Auth.User.slug')], ['class' => 'navbar-brand', 'escape' => false]) ?>
            <!--?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['controller' => 'stores', 'action' => 'view', $this->request->session()->read('Auth.User.id'), $this->request->session()->read('Auth.User.slug')], ['class' => 'btn btn-simbol btn-success-inv', 'title' => 'Ver mi Tienda', 'escape' => false]) ?-->
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?= $this->Html->link('<i class="ti-lock"></i> <p>Cambiar Contraseña</p>', ['controller' => 'stores', 'action' => 'changePassword', $this->request->session()->read('Auth.User.id'), $this->request->session()->read('Auth.User.slug')], ['escape' => false, 'id' => 'sidebar-password']) ?>
                </li>
				<li>
                    <a href="#">
						<i class="ti-settings"></i>
						<p>Configuración</p>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>