<!DOCTYPE html>
<html lang="en">
<head>

  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Mercapp: Administracion</title>
  <!-- CORE CSS-->
  <?= $this->Html->meta('mercapp.ico', '/mercapp.ico', ['type' => 'icon']) ?>

  <?= $this->Html->css('materialize.min.css') ?>
  <?= $this->Html->css('m-muli.css') ?>
  <?= $this->Html->css('themify-icons.css') ?>
  <?= $this->Html->css('custom2.css') ?>
  
  <?= $this->Html->css('animate.min.css') ?>
  
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>

</head>

<body class="mercapp-body">
  <div id="login-page" class="row">
    <div class="col s12 z-depth-6 card-panel">
        <?= $this->Form->create(null, ['class' => 'login-form']) ?>
        <div class="row" id="logo-custom">
          <div class="input-field col s12 center">            
            <?= $this->Html->image('mercapp.png', ['class' => 'logo-custom']); ?>
            <p class="center login-form-text">Siempre hay una tienda cerca de ti.</p>            
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="ti-user prefix"></i>
            <?= $this->Form->input('email', ['class' => 'validate', 'label' => false, 'templates' => ['inputContainer' => '{{content}}']]) ?>
            <label for="email" data-error="correo inválido" data-success="correo válido" class="center-align">Correo electrónico</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="ti-lock prefix"></i>
            <?= $this->Form->input('password', ['class' => 'validate', 'label' => false, 'templates' => ['inputContainer' => '{{content}}']]) ?>
            <label for="password">Contraseña</label>
          </div>
        </div>
        <!--div class="row">          
          <div class="input-field col s12 m12 l12  login-text">
              <input type="checkbox" id="remember-me" />
              <label for="remember-me">Recordarme</label>
          </div>
        </div-->
        <div class="row">
          <div class="input-field col s12 btn-mercapp">
            <?= $this->Form->button('Iniciar Sesión', ['class' => 'btn waves-effect waves-light col s12']) ?>
          </div>
        </div>
        <?= $this->Form->end() ?>
        <div class="row">
          <div class="input-field col s6 m6 l6">
            <p class="margin medium-small"><a class="link-mercapp" href="#">Registrate</a></p>
          </div>
          <div class="input-field col s6 m6 l6">
              <p class="margin right-align medium-small"><a class="link-mercapp" href="#">¿Olvidaste tu contraseña?</a></p>
          </div>          
        </div>
    </div>    
  </div>
</body>

<?= $this->Flash->render() ?>
  
  <!-- jQuery Library -->
  <?= $this->Html->script('jquery.min.js') ?>
  <!--materialize js-->
  <?= $this->Html->script('materialize.min.js') ?>
  <?= $this->Html->script('chartist.min.js') ?>
  <?= $this->Html->script('bootstrap-notify.js') ?>

  <?= $this->Html->script('demo.js') ?>

  <script type="text/javascript">
        $(document).ready(function(){

            var $msg = 'Bienvenido, inicie sesión o registrese como tienda.';
            var $icon = 'ti-info-alt';
            var $type = 'info';
            if ($('.msg-pop').length > 0) {
              $msg = $('.msg-pop').html();
              $icon = 'ti-alert';
              if ($('.msg-pop').hasClass('error')) {
                $type = 'danger';
              }
            }
            demo.initChartist();
            $.notify({
                icon: $icon,
                message: $msg

            },{
                type: $type,
                timer: 4000,
                placement: {
                  from: 'bottom',
                  align: 'right'
              }
            });

        });

        $(window).on('load', function() {
          
          $("#email").focus();

        });
  </script>

</html>