<?php
class Controller
{
    
    private static function getSnakeCaseName($className) {
        $className = preg_replace('/([a-z])([A-Z])/', '$1_$2', $className."s"); // Convertir CamelCase en snake_case
        $className = strtolower($className); // Convertir en minuscules
        return $className;
    }

    public function filter($params) {
        
        extract($params); // entity, foreign_key, filter_id
        $data = [];

        $conditions = [];
        
        if($filter_id) {
            $conditions[] = [$foreign_key, "=", $filter_id];
        }
        
        $data = $entity::whereAll($conditions);

        // if (!empty($conditions)) {
        //     $data = $entity::whereAll($conditions);
        // } else {
        //     $data = $entity::all();
        // }

        // if(in_array('annee_ID', (new $entity)->fillable())) {
        //     if($filter_id) {
        //         $data = $entity::whereAll([
        //             ["annee_ID", "=", Annee::active()->getId()],
        //             [$foreign_key, "=", $filter_id]
        //         ]);
        //     }
        //     else {
        //         $data = $entity::whereAll([
        //             ["annee_ID", "=", Annee::active()->getId()]
        //         ]);
        //     }
        // }
        // else {
        //     if($filter_id) {
        //         $data = $entity::whereAll([
        //             [$foreign_attr, "=", $filter_id]
        //         ]);
        //     }
        //     else {
        //         $data = $entity::all();
        //     }
        // }

        $result = [];
        foreach ($data as $element) {
            $result[] = $element->reciprocHydrate();
        }
        print_r(json_encode($result));

    }

    public function empty_field($entity) {
        $empty_field = false;
        foreach ($entity::attributs() as $attribut) {
            if($attribut['fillable'] && $_POST[$attribut['name']] == "") {
                // echo "<pre>"; print_r($attribut['name']); echo "shower <br>";
                $empty_field = true;
                $_POST[$attribut['name']] = htmlspecialchars($_POST[$attribut['name']]);
            }
        }
        return $empty_field;
    }

    public function add($params) {

        extract($params); // entity
            
        // echo "<pre>"; print_r($fill);
        if(!isset($_POST)) {
            $data = file_get_contents('php://input');
            $_POST = json_decode($data, true);
        }
        // echo "<pre>"; print_r($params);
        // echo "<pre>"; print_r($_POST); exit;

        if(count($_POST) == (new $entity)->count_fillable() && !$this->empty_field($entity)) {

            if (isset($_POST['image']) && !empty($_POST['image'])) {
                // Récupérer les données de l'image
                $imageData = $_POST['image'];
                
                // Convertir l'URL base64 en données binaires
                $imageData = str_replace('data:image/png;base64,', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);
                $imageBinary = base64_decode($imageData);
                
                $image_name = "salle_".uniqid().'.png';
                $imagePath = '../uploads/'.$image_name;
                
                // Écrire les données binaires dans un fichier
                if (file_put_contents($imagePath, $imageBinary) !== false) {
                    $_POST["photo"] = $image_name;                    
                } else {
                    $message = 'Erreur lors de l\'enregistrement de l\'image sur le serveur.';
                }
            } else {
                $message = 'Aucune donnée d\'image reçue.';
            }

            $res = $entity::create($_POST);

            if($res->getId()) {
                $alert = [ "alert" => "success", "message" => "Ajout effectué !" ];
            }
            else {
                $alert = [ "alert" => "error", "message" => "Une erreur est survenue !" ];
            }
        }
        else {
            $alert = [ "alert" => "warning", "message" => "Veuillez remplir tous les champs !" ];
        }

        echo json_encode($alert, JSON_UNESCAPED_UNICODE);

    }

    public function edit($params) {
        
        extract($params); // entity

        if(is_numeric($id)) {
            $res = ($entity::find($id))->update($_POST);
            if($res->getId()) {
                $alert = [ "alert" => "success", "message" => "Modification effectuée !" ];
            }
            else {
                $alert = [ "alert" => "warning", "message" => "Une erreur est survenue !" ];
            }
        } 
        else {
            $alert = [ "alert" => "error", "message" => "Cette opération ne peut être effectuée" ];
        }
        
        echo json_encode($alert, JSON_UNESCAPED_UNICODE);

    }

    public function find($params) {
        
        extract($params); // entity

        if(is_numeric($id)) {
            $res = $entity::find($id);
            if($res && $res->getId()) {
                return $res->attributes();
                // echo json_encode($res->attributes(), JSON_UNESCAPED_UNICODE);
            }
            else {
                $alert = [ "alert" => "warning", "message" => "Ce élément n'existe pas !" ];
                echo json_encode($alert, JSON_UNESCAPED_UNICODE);
            }
        }
        else {
            $alert = [ "alert" => "error", "message" => "Une erreur est survenue !" ];
            echo json_encode($alert, JSON_UNESCAPED_UNICODE);
        }
        
    }

    public function del($params) {
        
        extract($params); // entity

        if(is_numeric($id)) {
            $res = ($entity::find($id))->delete();
            if($res && $res->getId()) {
                $alert = [ "alert" => "success", "message" => "Suppression effectuée !" ];
            }
            else {
                $alert = [ "alert" => "warning", "message" => "Cette opération ne peut être effectuée !" ];
            }
        } 
        else {
            $alert = [ "alert" => "error", "message" => "Une erreur est survenue !" ];
        }
        
        echo json_encode($alert, JSON_UNESCAPED_UNICODE);

    }

    public function dataSPP($params) {

        // echo "<pre>"; print_r($params); exit;

        extract($params); // $entite
        
        //The model
        $model = new $entity();
        $entity_table = $model->table();
        // $primaryKey = 'id'; 
        $primaryKey = $entity_table.'.`id`';
        $attributs = $model->attributs();
        $joined = [];
        $table = '`'.$entity_table.'`';
        
        // $table = '`redaction`, `article`';

        $columns = [];
        foreach ($attributs as $attribut):
            if(!$attribut['fillable'] || ($attribut['fillable'] && $attribut['input_type'] != 'password')) {
                $name = $attribut['name'];
                $columns[] = array( 'db' => $entity_table.'.`'.$name.'`', 'dt' => $name );
                if(isset($attribut['foreign_key']) && $attribut['foreign_key']) {
                    $ref = $attribut['ref'];
                    $ref_lib = $attribut['ref_lib'];
                    // on indique qu'il y aura jointure si ce n'était pas encore le cas
                    if(!isset($joined['join'])) $joined['join'] = true; 
                    // a chaque fois on ajoute dans $table, la table qui sera impliquée dans la jointure
                    $table .= ', `'.$ref.'`';
                    // on va définir maintenant les conditions de jointures
                    if(!isset($joined['relation_and']) && !isset($joined['relation'])) {
                        $joined['relation_and'] = $entity_table.'.`'.$name.'` = '.$ref.'.`id` AND ';
                        $joined['relation'] = $entity_table.'.`'.$name.'` = '.$ref.'.`id` ';
                    }
                    else {
                        $joined['relation_and'] .= $entity_table.'.`'.$name.'` = '.$ref.'.`id` AND ';
                        $joined['relation'] .= 'AND '.$entity_table.'.`'.$name.'` = '.$ref.'.`id` ';
                    }
                    $columns[] = array( 'db' => $ref.'.`'.$ref_lib.'`', 'dt' => $ref.'_'.$ref_lib );
                }
            }
        endforeach;
                
        $sql_details = "";
        $whereResult = null;
        $whereAll = null;

        $data = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult, $whereAll, $joined);
    
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

    }
    
}
