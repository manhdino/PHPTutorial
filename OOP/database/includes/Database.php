<?php  

namespace App\Database;

use \Exception;//Class build-in in PHP
use \PDO; //Class build-in in PHP

class Database{
      
    private $driver = _DRIVER;
    private $host = _HOST;
    private $user = _USER;
    private $pass = _PASS;
    private $dbName = _DB;

    private  static $connection = null;
    private $sql = null;

    function __construct(){ //connect to DB
        /*
           * dsn: data source name include:
             + host
             + database name
             + user
             + password
             + charset,...
           
           * $connection must be declared in static variable cause if not
           every time we create a new object of class Database,
           $connection will be reset null 

        */
        try{
           if(class_exists('PDO')){
                $dsn = $this -> driver.':dbname='.$this->dbName.';host='.$this->host;
                $options = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Thrown a Exception if query is Error
                ];
                if(self::$connection == null){
                  self::$connection = new PDO($dsn, $this->user, $this->pass, $options);
                }
           }
        }catch(Exception $e){
            echo $e->getMessage();
            die();
        }
    }
  
    /* PDO::prepare — Prepares a statement for execution and returns a statement PDO object
       PDOStatement::execute — Executes a prepared statement and return true on success or false on failure*/
    public function query($sql,$data=[],$statementStatus=false){
      /**
       * return true,false if using for Insert,Update,Delete record in DB
       * return $statement if using for get data from DB
       */
           $this -> sql = $sql;
           $query = false;
           try{
            $statement = self::$connection->prepare($this->sql);
           if (empty($data)){
            $query = $statement -> execute();
           }else{
             $query = $statement -> execute($data); //Note: $data as Associative Arrays Form
           }
    }catch(Exception $e){
        echo $e->getMessage().'<br/>';
        echo '<b>SQL Query</b>: <i style="color: darkgreen;">'.$this->sql.'</i>';
        die(); 
    }
    if($statementStatus && $query){
        return $statement;
    }
    return $query;
  }
  
  /**
   * PDO::FETCH_ASSOC: return Associative Arrays with key is name of column in table
   */

  private function fetch($sql){
    $statement = $this -> query($sql,[],true);
    if(is_object($statement)){
      return $statement;
    }
    return false;
  }
  public function getAllRecord($sql){
      $statement = $this -> fetch($sql);
      if(!empty($statement)){
        return $statement -> fetchAll(PDO::FETCH_ASSOC);
      }
  }
  
  public function getFirstRecord($sql){
    $statement = $this -> fetch($sql);
      if(!empty($statement)){
        return $statement -> fetch(PDO::FETCH_ASSOC);
      }
  }
  /**
   * SQL Syntax Insert --> by using data insert Associative Arrays as a param
   * INSERT INTO table_name (column1, column2, column3, ...) VALUES (:column1, :column2, :column3, ...);
   * keyArr ~ column 
   */
  public function insertData($table,$dataInsert){
    $keyArr = array_keys($dataInsert);
    $fieldStr = implode(',', $keyArr);
    $valueStr = ':' . implode(', :', $keyArr);
    $sql = 'INSERT INTO ' . $table . '(' . $fieldStr . ')' . ' VALUES' . '(' . $valueStr . ')';
    return $this->query($sql,$dataInsert);
  }

  /**
   * SQL Syntax Update --> by using data insert Associative Arrays as a param
   * UPDATE table_name SET column1 =: column1, column2 =:column2, ... WHERE condition;
   */
  public function updateData($table,$dataUpdate,$condition=''){
    $updateStr = '';
    foreach ($dataUpdate as $key => $value) {
        $updateStr .= $key . '=:' . $key . ', ';
    }
    $updateStr = rtrim($updateStr, ', ');//Erase ", " in the end of $updateStr
    if (!empty($condition)) {
      $sql = 'UPDATE ' . $table . ' SET ' . $updateStr . ' WHERE ' . $condition;
  } else {
      $sql = 'UPDATE ' . $table . ' SET ' . $updateStr;
  }
  return $this->query($sql, $dataUpdate);
  }

  public function deleteData($table,$condition){
    if (!empty($condition)) {
      $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
  } else {
      $sql = 'DELETE FROM ' . $table;
  }
  return $this->query($sql);
  }

  public function getRows($sql){
    $statement = $this->query($sql, [], true);
    if (!empty($statement)){
        return $statement->rowCount();
    }
    return 0;
  }

  //get last Insert Id
  public function getLastInsertId(){
    return self::$connection -> lastInsertId();
  }
  
  public function getPDO(){
    return self::$connection;
  }
}