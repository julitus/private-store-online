<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Mercapp: Administracion';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta(
            'mercapp.ico',
            '/mercapp.ico',
            ['type' => 'icon']
        ) ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('animate.min.css') ?>
    <?= $this->Html->css('paper-dashboard.css') ?>
    <?= $this->Html->css('demo.css') ?>
    <?= $this->Html->css('m-font-awesome.min.css') ?>
    <?= $this->Html->css('m-muli.css') ?>
    <?= $this->Html->css('themify-icons.css') ?>
    <?= $this->Html->css('select2.min.css') ?>
    <?= $this->Html->css('custom.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="wrapper">

        <?= $this->element('sidebar') ?> 

        <div class="main-panel">
            <?= $this->element('header') ?>

                <div class="content">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>

            <?= $this->element('footer') ?>           
        </div>
    </div>
    
    <footer>
    </footer>
</body>

    <?= $this->Html->script('jquery-1.10.2.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('bootstrap-checkbox-radio.js') ?>
    <?= $this->Html->script('chartist.min.js') ?>
    <?= $this->Html->script('bootstrap-notify.js') ?>
    <?= $this->Html->script('moment.min.js') ?>
    <?= $this->Html->script('select2.min.js') ?>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzj6qq8MwKbswqrfZF9abk8FT6_p1Sb2s"></script>

    <?= $this->Html->script('paper-dashboard.js') ?>
    <?= $this->Html->script('demo.js') ?>
    <?= $this->Html->script('functions.js') ?>

</html>
