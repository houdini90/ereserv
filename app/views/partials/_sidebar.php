<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }    
    $request = "/".$_GET['r'];
?>

<div class="sidebar" style="background-color: #19233e;">

    <nav class="mt-2 mb-5">
        
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">

        <?php if((isset($_SESSION['username']) && $_SESSION['role'] == "utilisateur") || !isset($_SESSION['username']) ): ?>
            
            <li class="nav-item mt-1 <?php if($request == '/home' || $request == '/') echo 'menu-open' ?>">
                <a href="home" class="nav-link font-weight-bold <?php  if($request == '/home' || $request == '/') echo 'active'  ?>">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Accueil</p>
                </a>
            </li>

            <li class="nav-item mt-1 <?php if($request == '/reservation') echo 'menu-open' ?>">
                <a href="reservation" class="nav-link font-weight-bold <?php if($request == '/reservation') echo 'active' ?>">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Réserver salle</p>
                </a>
            </li>
        
            <li class="nav-item mt-1 <?php if($request == '/suivre') echo 'menu-open' ?>">
                <a href="suivre" class="nav-link font-weight-bold <?php if($request == '/suivre') echo 'active' ?>">
                    <i class="nav-icon fas fa-bullseye"></i>
                    <p>Suivre une demande</p>
                </a>
            </li>

        <?php elseif(isset($_SESSION['username']) && $_SESSION['role'] != "Utilisateur"): ?>

            <li class="nav-item mt-1 <?php if($request == '/dashboard' || $request == '/') echo 'menu-open' ?>">
                <a href="dashboard" class="nav-link font-weight-bold <?php  if($request == '/dashboard' || $request == '/') echo 'active'  ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Tableau de bord</p>
                </a>
            </li>
        
            <li class="nav-item mt-1 <?php if($request == '/salles') echo 'menu-open' ?>">
                <a href="salles" class="nav-link font-weight-bold <?php if($request == '/salles') echo 'active' ?>">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Salles</p>
                </a>
            </li>
            
            <li class="nav-item mt-1 <?php if($request == '/reservations') echo 'menu-open' ?>">
                <a href="reservations" class="nav-link font-weight-bold <?php if($request == '/reservations') echo 'active' ?>">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>Réservations</p>
                </a>
            </li>

            <?php if(isset($_SESSION['username']) && $_SESSION['role'] == "SuperAdministrateur"): ?>
            <li class="nav-item mt-1 <?php if($request == '/users') echo 'menu-open' ?>">
                <a href="users" class="nav-link font-weight-bold <?php if($request == '/users') echo 'active' ?>">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>Utilisateurs</p>
                </a>
            </li>
            <?php endif; ?>

        <?php endif; ?>
       
        
    </nav>
        
</div>

<script>
    $(function () {
        
    })
</script>