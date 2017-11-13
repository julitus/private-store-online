<div class="container-fluid mercapp-page"  data-sidebar="orders"> 

<div class="row mercapp-order">
    
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Orden( <label><span class="label label-code"><?= h($order->code) ?></span></label> )&nbsp;
                </h4>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Cliente</small></span><br>
                        <?= $order->client->first_name . ' ' . $order->client->last_name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Referencia</small></span><br>
                        <?= $order->address ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Correo Electrónico</small></span><br>
                        <?= $order->client->email ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Teléfono</small></span><br>
                        <?= $order->client->phone != '' ? $order->client->phone : '--' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Tienda</small></span><br>
                        <?= $order->store->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Hora</small></span><br>
                        <?= $order->created_hour ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Creado</small></span><br>
                        <?= $order->created_date ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Ult. Modificación</small></span><br>
                        <?= $order->modified_date ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7">
        <div class="card card-map">
            <div class="header">
                <h4 class="title">Detalles <label class="order-status-title"><?= $order->status ?></label></h4>
            </div>
            <div class="content table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th scope="col"><span class="text-success"><small>#</small></span></th>
                            <th scope="col"><span class="text-success"><small>Producto</small></span></th>
                            <th scope="col"><span class="text-success"><small>Cantidad</small></span></th>
                            <th scope="col"><span class="text-success"><small>Precio Unit.</small></span></th>
                            <th scope="col"><span class="text-success"><small>Sub Total</small></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order->order_details as $key => $detail): ?>
                            <tr>
                                <td><?= h($key + 1) ?></td>
                                <td><?= h($detail->warehouse->product->name . ' ' . $detail->warehouse->product->content . ' ' . $detail->warehouse->product->measure->abrev) ?></td>
                                <td><?= $detail->quantity ?></td>
                                <td><?= h($this->Number->format($detail->unit_price, ['before' => '$', 'locale' => 'es_ES'])) ?></td>
                                <td><?= h($this->Number->format($detail->quantity * $detail->unit_price, ['before' => '$', 'locale' => 'es_ES'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-custom-total">
                <span class="text-success"><small>Total: </small></span>
                <?= h($this->Number->format($order->total, ['before' => '$', 'locale' => 'es_ES'])) ?>
            </div>
            <div class="header">
                <h4 class="title">Ubicación</h4>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="map">
                            <div id="map-order" data-order='<?= $order ?>' ></div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="javascript:history.back()" class="btn btn-warning btn-fill btn-wd">Atrás</a>
                </div>
            </div>
        </div>
    </div>

</div>