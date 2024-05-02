<?php
class SalleController extends Controller
{
    
    public function index($params) {

        // $sous_programme = new SousProgramme();
        // $fillable = $sous_programme->fillable();
        // $attr = ['id', ...$fillable];

        $view = new CRUDView('crud');
        
        $view->render([
            "titrePage" => "Gestion des salles",
            "attributs" => Salle::attributs(),
            'entity' => Salle::class,
        ]);
    }


}
