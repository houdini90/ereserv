<?php echo $head; ?>
<!-- Main content -->
<body style="background: url('<?php echo ASSETS;?>img/salle.jpg') center center;">
    
    <section class="content" style="height: 65vh; background-color: rgba(0, 0, 0, 0.8); width: 68%; margin: auto; margin-top: 17.5vh; border-radius: 10px; padding: 10% 0px 70px 0px; padding-left: 6%; padding-right: 6%;">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>

            <div class="error-content text-white">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page introuvable.</h3>

                <p>
                    La page que vous demandez n'est pas retrouvée dans le système !
                    Cliquez ici <a href="home" style="color: #24a9ff;">pour retourner à l'accueil</a>
                </p>
                
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->

</body>

<?php echo $scripts; ?>