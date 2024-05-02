<?php

    Router::setRoute("/", "HomeController", "index");
    Router::setRoute("/home", "HomeController", "index");
    Router::setRoute("/reservation", "HomeController", "reservation");
    Router::setRoute("/disponibilite-([0-9]+)", "HomeController", "disponibilite", 'id');
    Router::setRoute("/reserver-salle-([0-9]+)", "HomeController", "reserverSalle", 'id');
    Router::setRoute("/suivre", "HomeController", "suivre");
    Router::setRoute("/salles", "SalleController", "index");
    Router::setRoute("/reservations", "ReservationController", "index");
    Router::setRoute("/users", "UserController", "index");
    
    Router::setRoute("/login", "UserController", "login");
    Router::setRoute("/log", "UserController", "log");
    Router::setRoute("/logout", "UserController", "logout");
    Router::setRoute("/dashboard", "HomeController", "dashboard");

    Router::setRoute("/accepter-([0-9]+)", "ReservationController", "accepter", 'id');
    Router::setRoute("/refuser-([0-9]+)", "ReservationController", "refuser", 'id');

    Router::setRoute("/suivi", "ReservationController", "suivi");
    // Liste des salles
    Router::setRoute("/liste-salle", "SalleController", "liste");
    // Liste des réservation de la salle
    Router::setRoute("/reservation-salle/([0-9]+)", "ReservationController", "liste", 'id');
    // Enregistrer réservation
    Router::setRoute("/reserver", "ReservationController", "reserver");








    // LES ROUTES CONCERNANT LE CRUD ET LE SPP

    // Recuperation de donnees
    Router::setRoute("/data/(.+)", "Controller", "dataSPP", 'entity');
    // Récupérer une données
    Router::setRoute("/find/(.+)/([0-9]+)", "Controller", "find", 'entity,id');
    // Ajout de données
    Router::setRoute("/add/(.+)", "Controller", "add", 'entity');
    // Modification de donnees
    Router::setRoute("/edit/(.+)/([0-9]+)", "Controller", "edit", 'entity,id');
    // Suppression de donnees
    Router::setRoute("/del/(.+)/([0-9]+)", "Controller", "del", 'entity,id');
    // Filtre de donnees
    Router::setRoute("/filter/(.+)/(.+)/([0-9]*)", "Controller", "filter", 'entity,foreign_key,filter_id');