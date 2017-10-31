<div class="container-fluid mercapp-page"  data-sidebar="others"> 

<?= $this->element('others') ?>

<div class="row mercapp-sub" id="mercapp-sub-0">

    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">Categoria(<?= $category->name ?>)</h4>
            </div>
            <div class="content">
                <div class="row row-view">
                    <div class="col-xs-12">
                        <span class="text-success"><small>Nombre</small></span><br>
                        <?= $category->name ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Categoria Padre</small></span><br>
                        <?= $category->has('parent_category') ? $category->parent_category->name : '--' ?>
                    </div>
                    <div class="col-xs-12">
                        <span class="text-success"><small>Sub Categorias</small></span><br>
                        <?php if (!empty($category->child_categories)): ?>
                        <table class="table-condensed">
                            <?php foreach ($category->child_categories as $key => $childCategories): ?>
                                <tr>
                                    <td><span class="text-success"><small><?= h($key +1) ?></small></span></td>
                                    <td><?= h($childCategories->name) ?></td>
                                </tr>
                                <?php endforeach; ?>
                        </table>
                        <?php else: ?>
                            No tiene sub categorias.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center">
                    <?= $this->Html->link(__('Atras'), ['action' => 'add'], ['class' => 'btn btn-warning btn-fill btn-wd']) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->element('indexCategories', ['categories' => $categories]) ?>

</div>

</div>