<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">
                    <?= $titrePage; ?>
                    <div class="" id=""></div>
                </h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            
        <div class="col-12">
                <div class="card table-responsive">
                    <div class="card-body">
                        <style>
                            td {
                                white-space: nowrap;
                            }
                        </style>
                        <table id="datatable" class="table table-bordered table-striped table-sm text-sm">
                            <thead>
                                <tr>
                                    <?php foreach ($attributs as $attribut): ?>
                                        <?php if(!$attribut['fillable'] || ($attribut['fillable'] && $attribut['input_type'] != 'password')): ?>
                                            <?php if(isset($attribut['foreign_key']) && $attribut['foreign_key']): ?>
                                                <th hidden scope="col"><?= $attribut['lib'] ?></th>
                                                <th scope="col"><?= $attribut['lib'] ?></th>
                                            <?php else: ?>
                                                <th scope="col"><?= $attribut['lib'] ?></th>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
	                                <th scope="col">Actions</th>
	                            </tr>
	                        </thead>
                            <tbody>
	                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</section>
<!-- /.content -->
