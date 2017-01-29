<?php

  namespace Model;

  class Model {
    protected $table;

    protected function getTable(){
      if(isset($this->table))
        return $this->table;
      echo get_class($this);
      return $this;
    }
  }
