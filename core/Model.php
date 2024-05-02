<?php
/**
 * 
 * class Structure
 */
class Model {

    
    protected $connection;

    protected $callingClass;
    
    protected $table;
    
    protected $id;

    protected $attributes = [];

    protected $fillable = [];

    // on doit pouvoir définir les éléments qui doivent être uniques, en solo ou en multiple

    public function fillable() {
        return $this->fillable;
    }

    public function attributes() {
        return $this->attributes;
    }
    
    public function count_fillable() {
        return count($this->fillable);
    }

    private static function getSnakeCaseName($className) {
        $className = preg_replace('/([a-z])([A-Z])/', '$1_$2', $className."s"); // Convertir CamelCase en snake_case
        $className = strtolower($className); // Convertir en minuscules
        return $className;
    }
    
    protected function fillableFromArray(array $attributes) {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }
        return $attributes;
    }

    public function fill(array $attributes = []) {
        $attributes = $this->fillableFromArray($attributes);
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
            // $this->setAttributes($key, $value);
        }
        return $this;
    }

    public function __call($method, $args)  {
        if (strpos($method, 'get') === 0) {
            $property = lcfirst(substr($method, 3));
            return $this->attributes[$property] ?? null;
        } elseif (strpos($method, 'set') === 0) {
            $property = lcfirst(substr($method, 3));
            // $this->attributes[$property] = $args[1] ?? null;
            $this->attributes[$property] = $args[0] ?? null; // j'ai changé le 1 en 0 lors d'un debuggage à la construction ed la function hydrade (semblable à fill)
        }
    }

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @param $valeurs array Les valeurs à assigner
     * @return void
     */
    public function __construct(array $valeurs = [])
    {
        if (!empty($valeurs)) {
            $this->hydrate($valeurs);
        }
        $this->callingClass = get_called_class();
        $this->table = self::getSnakeCaseName($this->callingClass);
        $this->connection = new DBConn("$this->table");
    }

    // ID GETTES AND SETTER
    public function id() {
        return $this->id;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        if(empty($id) || !is_int($id) || is_null($id)) {
            throw new InvalidArgumentException("L'identifiant doit être un nombre entier non null", 1);
        }
        $this->id = $id;
    }
    //TABLE GETTER
    public function table() {
        return $this->table;
    }
    
    /**
     * Méthode assignant les valeurs spécifiées aux attributs correspondant.
     * @param $donnees array Les données à assigner
     * @return void
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            $methode = 'set' . ucfirst($attribut);
            if (is_callable(array($this, $methode))) {
                $this->$methode($valeur);
            }
        }
    }

    /**
     * Reciproque de la function précédente
     * @return $data array Le tableau de données de base qui avait été assigné au niveau de la function hydrate
     */
    public function reciprocHydrate() {
        
        $data = [];
        $data["id"] = $this->getId();
        foreach ($this->fillable as $attribute) {
            $methode = 'get' . ucfirst($attribute);
            $data[$attribute] = $this->$methode();
        }
        
        return $data;
    }

    /**
     * Méthode permettant de savoir si l'élément du modèle est nouveau ou non.
     * @return bool
     */
    public function isNew() {
        return empty($this->getId());
    }

    /**
     * Create a new instance
     * @param array attributes 
     * @return $intance
     */
    public static function create(array $attributes = []) {
        
        $callingClass = get_called_class();
        $tableName = self::getSnakeCaseName($callingClass);

        $instance = new $callingClass;
        $attributes = $instance->fillableFromArray($attributes);
        $instance->fill($attributes);

        $connection = new DBConn("$tableName");
        if($id = $connection->create($instance->attributes)) {
            $instance->hydrate(["id" => $id]);
            
            return $instance;
        }
        return null;

    }

    /**
     * Update a specific instance
     * @param array attributes
     * @return $intance
     */
    public function update(array $attributes = []) {

        $id = $this->id() ?? null; // oh plutôt un get id

        if ($id !== null) {
            $attributes = $this->fillableFromArray($attributes);
            $this->fill($attributes);
            if($this->connection->update($id, $attributes)) {
                return $this;
            }
            return null;
        }
        
        throw new Exception("Vous ne pouvez pas modifier un élément qui n'existe pas !", 1);
        return false;

    }

    public static function find($id) {
        $callingClass = get_called_class();
        $tableName = self::getSnakeCaseName($callingClass);

        $connection = new DBConn("$tableName");
        $result = $connection->get($id);

        if ($result) {
            $instance = new $callingClass($result);
            // $instance->hydrate($result);
            return $instance;
        }

        return null;
    }

    public static function all() {

        $callingClass = get_called_class();
        $tableName = self::getSnakeCaseName($callingClass);

        $connection = new DBConn("$tableName");
        $result = $connection->all();

        $instances = [];
        foreach ($result as $row) {
            $instance = new $callingClass($row);
            $instances[] = $instance;
        }

        return $instances;

    }

    public static function first() {
        return static::all()[0];
    }

    public static function last() {
        $all = static::all();
        return $all[count($all)-1];
    }

    public static function where($attr, $op, $val) {
        $callingClass = get_called_class();
        $tableName = self::getSnakeCaseName($callingClass);

        $connection = new DBConn($tableName);
        $result = $connection->where($attr, $op, $val);

        $instances = [];
        foreach ($result as $row) {
            $instance = new $callingClass($row);
            $instances[] = $instance;
        }

        return $instances;
    }

    public static function whereAll($conditions) {
        $callingClass = get_called_class();
        $tableName = self::getSnakeCaseName($callingClass);

        $connection = new DBConn($tableName);
        $result = $connection->whereAll($conditions);

        $instances = [];
        foreach ($result as $row) {
            $instance = new $callingClass($row);
            $instances[] = $instance;
        }

        return $instances;
    }

    public function delete() {
        
        $id = $this->id() ?? null;

        if ($id !== null) {

            if($this->referenced())
                return null;

            if($this->connection->delete($id))
                return $this;
        
        }

        return null;
    }

}