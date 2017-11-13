<div class="container-fluid mercapp-page"  data-sidebar="orders">

<div class="row mercapp-product">

    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h4 class="title">
                    Mis Ordenes&nbsp;
                </h4>
            </div>
            <div class="content table-responsive">
                <?php if($orders->count()): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?= $this->Paginator->sort('code', 'Código') ?></th>
                            <th scope="col">Hora</th>
                            <th scope="col"><?= $this->Paginator->sort('store_id', 'Referencia') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('client_id', 'Cliente') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('total', 'Monto') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status', 'Estado') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created', 'Registrado') ?></th>
                            <th scope="col" class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $key => $order): ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <td><label><span class="label label-code"><?= h($order->code) ?></span></label></td>
                            <td onmouseover="titleDate($(this), '<?= $order->created ?>');" class="title-hover"><?= h(date($hour_format, strtotime($order->created))) ?></td>
                            <td><?= $order->address ?></td>
                            <td><?= $order->client->first_name . ' ' . $order->client->last_name ?></td>
                            <td>
                                <?= h($this->Number->format($order->total, ['before' => '$', 'locale' => 'es_ES'])) ?>
                            </td>
                            <td>
                                <?php /*Falta definir los estados de una orden*/ ?>
                                <?= $order->status ?>    
                            </td>
                            <td><?= h(date($date_format, strtotime($order->created))) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<span class="ti-eye" aria-hidden="true"></span>'), ['action' => 'view', $order->id, $order->code], ['class' => 'btn btn-simbol btn-success', 'title' => 'Ver', 'escape' => false]) ?>
                                <?php if($order->status != 1): ?>
                                    <?= $this->Form->postLink(__('<span class="ti-trash" aria-hidden="true"></span>'), ['action' => 'delete', $order->id], ['confirm' => __('¿Estas seguro que quieres eliminar el registro # {0}?', $order->code), 'class'=>'btn btn-simbol btn-success', 'title' => 'Eliminar', 'escape' => false]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="header">
                    <ul class="pagination">
                        <?= $this->Paginator->first('&lsaquo;', ['escape' => false]) ?>
                        <?= $this->Paginator->prev('&laquo;', ['escape' => false]) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('&raquo;', ['escape' => false]) ?>
                        <?= $this->Paginator->last('&rsaquo;', ['escape' => false]) ?>
                    </ul>
                    <p class="category counter"><?= $this->Paginator->counter('Resultados {{start}} - {{end}} de {{count}}, página {{page}} / {{pages}}') ?></p>
                </div>
                <?php else: ?>
                    <div class="header">
                        <p class="category">No hay ordenes registradas.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

</div>
