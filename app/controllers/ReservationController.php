<?php
class ReservationController extends Controller
{
    
    public function index($params) {

        // $view = new PageView('reservations');
        
        // $view->render([
        //     "titrePage" => "Gestion des reservations",
        //     "attributs" => Reservation::attributs(),
        // ]);

        $view = new CRUDView('crud');
        
        $view->render([
            "titrePage" => "Gestion des réservations",
            "attributs" => Reservation::attributs(),
            'entity' => Reservation::class,
        ]);
    }
    
    public function accepter ($params) {
        extract($params); // reference
        $reservation = Reservation::find($id);
        $reservation->update([
            "statut" => 1
        ]);
        // echo "<pre>"; print_r($reservation); exit;
        $alert = [ "alert" => "success", "message" => "Demande de réservation accepté !" ];
        echo json_encode($alert, JSON_UNESCAPED_UNICODE);
    }

    public function refuser ($params) {
        extract($params); // reference
        $reservation = Reservation::find($id);
        $reservation->update([
            "statut" => 2
        ]);
        $alert = [ "alert" => "success", "message" => "Demande de réservation refusée !" ];
        echo json_encode($alert, JSON_UNESCAPED_UNICODE);
    }

    public function suivi ($params) {

        $params = file_get_contents('php://input');
        $params = json_decode($params, true);
        // echo "<pre>"; print_r($params);

        extract($params); // reference

        $reservation = Reservation::where("reference", "=", $reference);
        $response = [];

        if(count($reservation) > 0) {
            // echo "<pre>"; print_r($reservation[0]->getSalle_id()); exit;
            $salle = Salle::find($reservation[0]->getSalle_id());
            $response = [
                "statut" => "OK",
                "data" => [
                    "statut" => $reservation[0]->getStatut(),
                    "salle_nom" => $salle->getNom(),
                    "salle_capacite" => $salle->getCapacite(),
                ]
            ];
        }
        else {
            $response = [
                "statut" => "NOT_FOUND",
                "data" => []
            ];
        }

        echo json_encode($response);

    }

    public function reserver ($params) {

        $params = file_get_contents('php://input');
        $params = json_decode($params, true);
        // echo "<pre>"; print_r($params);
        
        extract($params); // salle_id, date_debut, date_fin

        $reservable = true;

        $reservations = Reservation::whereAll([
            ["statut", "=", 1],
            ["salle_id", "=", $salle_id]
        ]);

        if(count($reservations) > 0) {
            foreach($reservations as $reservation) {
                if(($reservation->getDate_debut() > $date_debut && $reservation->getDate_fin() > $date_debut) || ($reservation->getDate_debut() > $date_fin && $reservation->getDate_fin() > $date_fin)) {
                    
                }
            }
        }
        else {
            $reservable = false;
        }
        
        if($reservable) {
            $params['reference'] = uniqid();
            $reservation = Reservation::create($params);
            if($reservation) {
                $response = [
                    "statut" => "OK",
                    "data" => [
                        'reference' => $reservation->getReference(),
                    ]
                ];
            }
            else {
                $response = [
                    "statut" => "CREATE_FAIL",
                    "data" => []
                ];
            }
        }
        else {
            $response = [
                "statut" => "SALLE_INDISPONIBLE",
                "data" => []
            ];
        }        

        echo json_encode($response);

    }

}
