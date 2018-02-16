<?php
/**
 * Base Model Class
 */
class Model{

    protected $db;
    protected $table; 
    protected $fields = array();
    /**
     * Constructs model class with database connection and table name
     */
    public function __construct($table){
        $dbconfig = $GLOBALS['config']['DB_CONFIG'];
        $this->db = new Mysql($dbconfig);
        $this->table = $table;
    }
    /**
     * Get the list of table fields
     */
    protected function getFields(){
        $sql = "DESC ". $this->table;
        $result = $this->db->getFullQueryArray($sql);
        foreach ($result as $v) {
            if($v['Type'] != 'timestamp'){
                if($v['Type'] != 'geometry'){
                    $this->fields[] = $v['Field'];
                    if ($v['Key'] == 'PRI') {
                        $pk = $v['Field'];
                    }
                }
            }
        }
        if (isset($pk)) {
            $this->fields['pk'] = $pk;
        }
    }
    /**
     * Insert records
     * @access public
     * @param $list array associative array
     * @return mixed If succeed return inserted record id, else return false
     */
    public function insert($list){
        $fieldList = '';  //field list string
        $valueList = '';  //value list string
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields)) {
                $fieldList .= "`".$k."`" . ',';
                $valueList .= "'".$v."'" . ',';
            }
        }
        $fieldList = rtrim($fieldList,',');
        $valueList = rtrim($valueList,',');
        $sql = "INSERT INTO `{$this->table}` ({$fieldList}) VALUES ($valueList)";
        if ($this->db->query($sql)) {
            return $this->find($this->db->getInsertId());
        } else {
            $this->errorThrow();
        }
    }
    /**
     * Update records
     * @access public
     * @param $list array associative array needs to be updated
     * @return mixed If succeed return the count of affected rows, else return false
     */
    public function update($list){
        $uplist = '';
        $where = 0;
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields) || $k == 'id') {
                if ($k == $this->fields['pk'] || $k == 'id') {
                    $where = "`{$this->fields['pk']}`=$v";
                    $id = $v;
                } else {
                    $uplist .= "`$k`='$v'".",";
                }
            }
        }
        $uplist = rtrim($uplist,',');
        $sql = "UPDATE `{$this->table}` SET {$uplist} WHERE {$where}";
        if ($this->db->query($sql)) {
            if ($rows = $this->db->affectedRows()) {
                return $this->find($id);;
            } else {
                $this->errorThrow();
            }    
        } else {
            $this->errorThrow();
        }
    }
    /**
     * Find list of primary key values
     * @access public
     * @param $list array of primary keys
     * @return mixed If succeed return the results, else return false
     */
    public function findList($list){
        $result = array();
        foreach ($list as $k => $v) {
            $result[$k] = $this->find($v);
        }
        return $result;
    }
    /**
     * Delete records
     * @access public
     * @param $pk mixed could be an int or an array
     * @return mixed If succeed, return the count of deleted records, if fail, return false
     */
    public function delete($pk){
        $where = 0;
        if (is_array($pk)) {
            $where = "`{$this->fields['pk']}` in (".implode(',', $pk).")";
        } else {
            $where = "`{$this->fields['pk']}`= $pk";
        }
        $sql = "DELETE FROM `{$this->table}` WHERE $where";
        if ($this->db->query($sql)) {
            if ($rows = $this->db->affectedRows()) {
                return ['rows_deleted'=>$rows, 'row_ids'=>$pk];
            } else {
                $this->errorThrow();
            }        
        } else {
            $this->errorThrow();
        }
    }
    /**
     * Get info based on PK
     * @param $pk int Primary Key
     * @return array an array of single record
     */
    public function find($pk)
    {
        $sql = "select * from `{$this->table}` where `{$this->fields['pk']}`=$pk";
        $queryArray = $this->db->getFullQueryArray($sql);
        return $queryArray[0];
    }
    /**
     * Get all info from table
     * @return array an array of all records
     */
    public function all()
    {
        $fieldList = '';
        foreach ($this->fields as $k => $v) {
            $fieldList .= "$v".","; 
        }
        $fieldList = rtrim($fieldList,',');
        $sql = "select {$fieldList} from `{$this->table}`";
        $queryArray = $this->db->getFullQueryArray($sql);
        return $queryArray;
    }
    /**
     * Get the count of all records
     *
     */
    public function total()
    {
        $sql = "select count(*) from {$this->table}";
        $total = $this->db->getFullQueryArray($sql);
        return $total[0]['count(*)'];
    }
    /**
     * Error response on db level
     */
    public function errorThrow()
    {
        $errorArray = $this->db->getError();
        $error = new ErrorHandler;
        $error->databaseError($errorArray);
    }
}
