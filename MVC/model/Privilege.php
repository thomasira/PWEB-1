<?php

require_once "./model/Crud.php";

class Privilege extends Crud {
    public $table = "pw2tp3_privilege";
    public $primaryKey = "id";
    public $fillable = ["id", "privilege"];
}

?>