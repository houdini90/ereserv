<?php
class HomeController extends Controller
{
    
    public function index($params) {

        $view = new PageView('home');
        
        $view->render([
            "titrePage" => "Bienvenue sur eReserv"
        ]);
    }
    
    public function dashboard($params) {

        $view = new PageView('dashboard');

        $nb_salles = count(Salle::all());
        $nb_reservations = count(Reservation::all());
        $nb_users = count(User::all());
        
        $view->render([
            "titrePage" => "Tableau de bord",
            "nb_salles" => $nb_salles,
            "nb_reservations" => $nb_reservations,
            "nb_users" => $nb_users,
        ]);
    }

    public function reservation($params) {

        $view = new PageView('reservation');

        $salles = Salle::all();
        
        $view->render([
            "titrePage" => "Réservation d'une salle",
            "salles" => $salles
        ]);
    }

    public function suivre($params) {

        $view = new PageView('suivre');
        
        $view->render([
            "titrePage" => "Suivi de demande"
        ]);
    }

    public function disponibilite($params) {

        extract($params);

        $reservations = Reservation::where("salle_id", "=", $id);

        $view = new PageView('disponibilite');
        
        $view->render([
            "titrePage" => "Disponibilité de la salle",
            "reservations" => $reservations
        ]);
    }

    public function reserverSalle($params) {

        extract($params);

        $view = new PageView('reserverSalle');
        
        $view->render([
            "salle_id" => $id,
            "titrePage" => "Réservation"
        ]);
    }

}
