<?php
/**
 * 
 * class Salle
 */
class Salle extends Model {

    protected $fillable = ['nom', 'capacite', 'equipements', 'photo'];

    protected static $attributs = [
        [
            'name' =>  'id',
            'lib' => '#ID',
            'type' => 'int',
            'fillable' => false,
            'primary_key' => true,
            'auto_increment' => true,
            'required' => 'required'
        ],
        [
            'name' =>  'nom',
            'lib' => 'Nom',
            'type' => 'string',
            'primary_key' => false,
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'text',
            'required' => 'required'
        ],
        [
            'name' =>  'capacite',
            'lib' => 'Capacité',
            'type' => 'string',
            'primary_key' => false,
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'number',
            'required' => 'required'
        ],
        [
            'name' =>  'equipements',
            'lib' => 'Equipements',
            'type' => 'string',
            'primary_key' => false,
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'textarea',
            'required' => 'required'
        ],
        [
            'name' =>  'photo',
            'lib' => 'Photo',
            'type' => 'string',
            'primary_key' => false,
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'file',
            'required' => 'required'
        ],
    ];
    
    public static function attributs() {
        return self::$attributs;
    }

    // public function referenced() {
    //     if(ObjectifsSpecifique::where("sous_programme_ID","=",$this->getId()))
    //         return true;
    //     else
    //         return false;
    // }
    
    
}