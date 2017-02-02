<?php
  namespace Model;

  use Core\Database;

  class Model {
    protected $table;
    protected $sql;
    protected $mode;  // select | update | insert | delete
    protected $where_set = false;
    protected $fillable = [];
    public $result;

    protected function getTable(){
      if(isset($this->table))
        return $this->table;
      $this->table = strtolower(str_replace('Model\\', '', get_class($this)) . 's');
      return $this->table;
    }

    public function select($keys = []){
        if(!isset($this->mode)){
          $this->mode = "select";
          if(!empty($keys)){
            $keyString = "";
            for($i = 0; $i < count($keys); $i++){
              $keyString .= '`' . $keys[$i] . '`';
              if($i != (count($keys) -1))
                $keyString .= ', ';
            }
          }
          else{
            $keyString = '*';
          }
          $this->sql = "SELECT $keyString FROM `" . $this->getTable() . "`";
        }
        return $this;
    }
    /**
    * Insert the given key array into the table.
    *
    * @return False if mode isn't set, self on success (to chain methods).
    */
    public function insert($keyArray){
      if(!isset($this->mode)){
        $this->mode = 'insert';
        $values = "";
        $keys = "";
        $count = 0;
        foreach($keyArray as $key => $value){
          if(in_array($key, $this->fillable)){
            $format = (!in_array(gettype($value), ['integer', 'double'])) ? "'%s'" : "%s";
            if($count == 0){
              $keys .= '`' . $key . '`';
              $values .= sprintf($format, $value);
            }
            else{
              $keys .= ', `' . $key . '`';
              $values .= ', ' . sprintf($format,$value);
            }
            $count++;
          }
          else{
            return false;
          }
        }
        $values = "($values)";
        $keys = "($keys)";
        $this->sql = "INSERT INTO `" . $this->getTable() . "` $keys VALUES $values";
        return $this->execute();
      }
      else{
        return false;
      }
    }

    public function update($keyArray = []){
      if(!is_array($keyArray))
        return false;
      if($this->mode == 'update' && empty($keyArray))
        return $this->execute();
      if(isset($this->mode))
        return false;

      $this->mode = "update";
      $this->sql = sprintf("UPDATE `%s` SET ", $this->getTable());
      $set = "";
      $count = 0;
      foreach($keyArray as $key => $value){
        $format = (!in_array(gettype($value), ['integer', 'double'])) ? "'%s'" : "%s";
        if($count == 0)
          $set .= sprintf("`%s` = $format", $key, $value);
        else
          $set .= sprintf(", `%s` = $format", $key, $value);
        $count++;
      }
      $this->sql .= $set;
      return $this;
    }

    public function delete($go = false){
      if(isset($this->mode))
        if($this->mode == 'delete' && $go)
          return $this->execute();
        else
          return false;

      $this->mode = 'delete';
      $this->sql = sprintf("DELETE FROM `%s`", $this->getTable());
      return $this;
    }
    public function where($key, $operator, $value, $enclosed = false){
      $add = ($this->where_set) ? "AND" : "WHERE";
      $enclosure = ($enclosed) ? "'" : "";
      if(in_array($this->mode, ['select','update','delete'])){
        if(in_array($operator, ['=', '>', '<', '>=', '<>', '<='])){
          $this->where_set = true;
          $this->sql .= " $add `" . htmlentities($key) . "` $operator " . $enclosure . htmlentities($value) . $enclosure;
          return $this;
        }
        elseif($operator == 'in'){
          $this->where_set = true;
          if(is_array($value)){
            $value_string = "";
            for($i=0; $i < count($value); $i++){
              if($i != 0)
                $value_string .= ", ";
              $value_string .= htmlentities($value[$i]);
            }
            $operator = strtoupper($operator);
            $this->sql .= " $add `" . htmlentities($key) . "` $operator (" . $value_string . ")";
            return $this;
          }
        }
      }
    }

    public function get($limit = null, $start = null){
      if(isset($this->sql) && $this->mode == 'select'){
        $start = (isset($start)) ? $start : 0;
        if(isset($limit)){
          $this->sql .= " LIMIT $start, $limit";
        }
        return $this->execute();
      }
    }
    public function first(){
      if(isset($this->sql) && $this->mode == 'select'){
        $this->sql .= " LIMIT 1";
        $result = $this->execute();
        if(empty($result))
          return false;
        return $result[0];
      }
    }
    protected function execute(){
      $db = Database::getInstance();
      $this->result = [];

      if($this->mode == 'select'){
        $res = $db->query($this->sql);
        if($res){
          while($tempRes = $res->fetch_object()){
            $this->result[] = $tempRes;
          }
          $this->mode = null;
          $this->sql = null;
          $this->where_set = false;
          return $this->result;
        }
        else{
          return false;
        }
      }
      else{
        if($this->mode == 'insert'){
          $db->query($this->sql);
          return $db->insert_id;
        }
        $db->query($this->sql);
      }
      $this->mode = null;
      $this->sql = null;
      $this->where_set = false;

    }
  }
