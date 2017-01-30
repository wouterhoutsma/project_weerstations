<?php

  namespace Model;

  use Core\Database;

  class Model {
    protected $table;
    protected $sql;
    protected $mode;  // select | update | insert | delete
    protected $where_set = false;
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

    public function where($key, $mode, $value, $enclosed = false){
      $add = ($this->where_set) ? "AND" : "WHERE";
      $enclosure = ($enclosed) ? "'" : "";

      if(in_array($mode, ['=', '>', '<', '>=', '<>', '<='])){
        if(in_array($this->mode, ['select','update','delete'])){
          $this->where_set = true;
          $this->sql .= " $add `" . htmlentities($key) . "` $mode " . $enclosure . htmlentities($value) . $enclosure;
          return $this;
        }
      }
      elseif($mode == 'in'){
        $this->where_set = true;
        if(is_array($value)){
          $value_string = "";
          for($i=0; $i < count($value); $i++){
            $value_string .= htmlentities($value);
            if($i == count($value)-1)
              $value_string .= ", ";
          }
          $this->sql .= " $add `" . htmlentities($key) . "` $mode (" . $value_string . ")";
          return $this;
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
        return $this->execute()[0];
      }
    }
    protected function execute(){
      $db = Database::getInstance();
      $this->result = [];
      $res = $db->query($this->sql);
      if($res){
        while($tempRes = $res->fetch_object()){
          $this->result[] = $tempRes;
        }
        return $this->result;
      }
      else{
        return false;
      }
    }
  }
