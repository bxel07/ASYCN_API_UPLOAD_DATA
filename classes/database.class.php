<?php 

class database {
    protected static $instance;
    protected static $con;
    protected  $query;
    protected static $table;
    protected $values = array();
    protected $query_type;


    public static function table($table) {
        self::$table = $table;
        if(!self::$instance) {
            self::$instance = new self();
        }

        if(!self::$con) {
            try {
                $string = "mysql:host=".DB_HOST.";dbname=".DB_NAME; 
                self::$con = new PDO($string,DB_USERNAME,DB_PASSWORD);
    
            } catch (PDOException $e) {
                echo $e->getMessage();
                die;
            }
        };

        
        return self::$instance;
    }

    protected function run($data = array()) {
        $stm = self::$con->prepare($this->query);
        $check = $stm->execute($data);
        print_r($check);
        
        switch($this->query_type) {
            case 'select':
                if($check) {
                    $data = $stm->fetchAll(PDO::FETCH_OBJ);
                       if(is_array($data) && count($data) > 0) {
                           return $data;
                       }
                   }
                break;
            case 'update':
                #code
                return true;
                break;
            case 'insert':
                if($check) {
                    print_r($data);
                    echo "data inserted";
                    return true;
                }
                return true;
                break;
            case 'delete':
                if($check) {
                    print_r($data);
                    echo "data has been deleted";
                    return true;
                }
                break;
            default :
                #code
                return true;
                break;
        }
        
         return false;
    }

    public function select() {
        $this->query_type = "select";
        $this->query = "select * from " . self::$table. " ";
        return self::$instance;
    }

    public function all() {
        return $this->run();
    }

    public function where($where, $values = array()) {
        switch($this->query_type) {
            case 'select':
                $this->query .= " where " . $where ;
                return $this->run($values);
                break;
            case 'update':
                $values = array_merge($this->values,$values);
                $this->query .= " where " . $where ;
                return $this->run($values);
                break;
            default :
                #code
                return true;
                break;
        }
       
    }

    public function update(array $values) {
        $this->query_type = "update";
        $this->query = "update " . self::$table. " set ";

        foreach($values as $key => $value) {
            $this->query .= $key . "= :" .$key;
        }
    
        $this->values = $values;

        return self::$instance;
    }

    public function insert(array $data) {

        if(is_array($data) && count($data) > 0){
            $this->query_type = "insert";
            $this->query = "insert into " . self::$table."(name, format, size) VALUES (:name, :format, :size)";
            return $this->run($data);
            
        }
        return self::$instance;
    }

    public function delete(int $data) {
        if($data != null){
            try{
                $stm = self::$con->prepare("delete from " . self::$table ." where id = :id");
                $stm->bindParam(":id", $data, PDO::PARAM_INT);
                $stm->execute();
                echo "suscess";
            }catch(TypeError $e) {
                echo $e->getMessage();
            }
        }
        return self::$instance;
    }

    public function query($query, $values = array()) {
        $stm = self::$con->prepare($query);
        $check = $stm->execute($values);
                if($check) {
                    $data = $stm->fetchAll(PDO::FETCH_OBJ);
                    if(is_array($data) && count($data) > 0) {
                        return $data;
                    }
                }
                return false;
    }
}

?>