<?php
namespace App\Database;
use App\Database\Database;

class Business extends Database{

    protected $table = null; //table
    protected $primaryKey = 'id'; //primary key table
    protected $field = '*'; //field select

    public function __construct(){
        parent::__construct(); //call __construct của class Database(parent class) 

        $this->table = $this->getTable();
    }

    public function get($where=''){
        
        $tableName = $this->table;
        $fieldSelect = $this->field;

        $sql = "SELECT $fieldSelect FROM $tableName";
        if (!empty($where)){
            $sql.=" WHERE $where";
        }

        return $this->getAllRecord($sql);
    }

    //Get First Record 
    public function first($where=''){
        $tableName = $this->table;
        $fieldSelect = $this->field;

        $sql = "SELECT $fieldSelect FROM $tableName";

        //Nếu có where, nối câu lệnh sql với mệnh đề where
        if (!empty($where)){
            $sql.=" WHERE $where";
        }

        return $this->getFirstRecord($sql);
    }

    //Get 1 record for Id
    public function find($id){
        $findBy = $this->primaryKey;
        $where = "$findBy = $id";

        return $this->first($where);
    }

    public function count($where = ''){
        $tableName = $this->table;
        $fieldSelect = $this->primaryKey;

        $sql = "SELECT $fieldSelect FROM $tableName";

        if (!empty($where)){
            $sql.=" WHERE $where";
        }

        return $this->getRows($sql);
    }


    public function insert($dataInsert){
        $tableName = $this->table;

        return $this->insertData($tableName, $dataInsert);
    }

    public function update($dataUpdate, $id){
        $updateBy = $this->primaryKey;
        $condition = "$updateBy = ".$id;
        $tableName = $this->table;

        return $this->updateData($tableName, $dataUpdate, $condition);
    }


    public function delete($id){
        $deleteBy = $this->primaryKey;
        $tableName = $this->table;
        $condition = "$deleteBy = $id";

        return $this->deleteData($tableName, $condition);
    }

    private function getTable(){
        $currentClassObj = new \ReflectionClass($this);

        if (!empty($currentClassObj)){
            $currentClass = $currentClassObj->getShortName();
            if (!empty($currentClass)){
                $tableName = preg_replace('/([A-Z])/', '_$1', $currentClass);

                $tableName = trim($tableName, '_');

                $tableName = strtolower($tableName);

                return $tableName;
            }
        }

        return;
    }
}