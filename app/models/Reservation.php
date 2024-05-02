<?php
/**
 * 
 * class Reservation
 */
class Reservation extends Model {

    protected $fillable = ['salle_id', 'date_debut', 'date_fin', 'reference', 'statut'];

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
            'name' =>  'salle_id',
            'lib' => 'Salle',
            'type' => 'int',
            'primary_key' => false,
            'foreign_key' => true,
            'ref' => 'salles',
            'ref_lib' => 'nom',
            'ref_class' => 'Salle',
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'select',
            'required' => 'required',
        ],
        [
            'name' =>  'date_debut',
            'lib' => 'Date de début',
            'type' => 'string',
            'primary_key' => false,
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'date',
            'required' => 'required'
        ],
        [
            'name' =>  'date_fin',
            'lib' => 'Date de fin',
            'type' => 'string',
            'primary_key' => false,
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'date',
            'required' => 'required'
        ],
        [
            'name' =>  'reference',
            'lib' => 'Référence',
            'type' => 'string',
            'primary_key' => false,
            'auto_increment' => false,
            'fillable' => true,
            'input_type' => 'text',
            'required' => 'required'
        ]
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

    public static function create(array $attributes = [])
    {
        
        
        
        return parent::create($attributes);

    }
    
    
}