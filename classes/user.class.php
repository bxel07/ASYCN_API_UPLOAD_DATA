<?php 

class User {


    protected static $instance;
    function __construct() {
        #code
    }

    public static function action() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function create(array $args) {
        return database::table('image')->insert($args);
    }

    public function update_by_id(array $values,$id) {
        return database::table('image')->update($values)->where("id = :id",["id"=>$id]);
    }

    public function delete($values) {
        return database::table('image')->delete($values);
    }
 

    public function get_all() {
        return $data = database::table('image')->select()->all();
    }

    //for getting data  or updating data 
    public function __call($function, $params) {
        $value = $params[0];
        $column = str_replace("get_by_","", $function);
        $column = addslashes($column);

        //get colum information
        $val = database::table('image')->select()->query('show COLUMNS from image');
        $all_columns = array_column($val, "Field");


        //check colum exists or not in database
        if(in_array($column, $all_columns)){
            return $data = database::table('image')->select()->where($column . " = :" . $column,[$column =>$value]);

        }
        return false;
    }
}
?>