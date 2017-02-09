<?php
namespace Model;

class Average extends Model {

  protected $fillable = [
    'day',
    'month',
    'year',
    'stn',
    'weight',
    'temp'
  ];
  protected $table = 'averages';

  public function __construct(){}

}
?>
