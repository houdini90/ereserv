<?php
    
    session_start();
    include_once('./core/autoload.php');
    MyAutoload::start();

    if(isset($_GET['r'])) {
        $request = "/".$_GET['r'];
        $router = new Router($request);
    }
    else {
        $request = $redirect = '/home';
        $router = new Router($request);
        $router->redirect($redirect, $request);
    }
    
    // # Gestion des droits d'accès

    // vérifier cookies

    // vérifier sessions

    // vérification de l'authentification

    // gestion des droits d'accès
    
    
    $router->renderController();

?>