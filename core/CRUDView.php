<?php

/**
 * class PageView
 * use to call views, for simple page that use CRUD
 */

/**
 * 
 * Caractéristiques d'une page crud
 * 
 * Boutons de détails de suppression et de détails dans le datatable
 * Bouton d'ajout ♠♠♠
 * Prompt de confirmation de la suppression
 * 
 * Tableau d'affichage des donnée (data table)
 * Formulaire d'ajout dans un modal
 * Formulaire de modification dans un modal
 *  
 * Le dernier lot d'élément va dépendre de la structure de la données à manipuler 
 * On aura donc à faire des configs
 * Au niveau aussi de ces éléments intervient le js, et ce dernier doit pouvoir accéder aux configs
 * Au aura aussi l'intervention du js pour la confirmation de la suppresion
 * 
 * En ce qui concerne le datatable, on aura à intégérer datatables serverside
 * 
 * 
 * MISE EN PLACE
 * 
 * AFFICHAGE DES DONNEES
 * 
 */

class CRUDView extends View {
    
    public function render($params = array()) {

        $elements = parent::render($params);
        extract($elements);
        extract($params);

        // on doit trouver ici le moyen de transmettre les attributes à la pages (ce sera dont le fillable d'une instance d'une classe données),



        include_once(VIEWS.'templates/layout.php');

    }

}
