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
        <div style="display: flex; background: url('<?= ASSETS; ?>img/salle.jpg') center center;">
            <div style="height: 80vh; width: 100%; flex-direction: column; align-items: center;" class="">
                <div style="background-color: rgba(0, 0, 0, 0.4); height: 80vh; width: 100%;" class="p-4">
                    <div><a href="reservation"><button class="btn btn-lg bg-primary mb-3">Réserver une salle</button></a></div>
                    <div><a href="suivre"><button class="btn btn-lg bg-info mb-3">Vérifier le statut d'une demande</button></a></div> 
                </div>               
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
