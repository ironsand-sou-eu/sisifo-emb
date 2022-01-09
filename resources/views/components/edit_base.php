<!-- Page Heading -->
<?= $this->Html->css('estilos_edit.css'); ?>
<h1 class="h3 mb-2 text-gray-800"><?= $this->fetch('titulo'); ?></h1>
<p class="mb-4"><?=$this->fetch('descricao'); ?></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <?= $this->fetch('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>