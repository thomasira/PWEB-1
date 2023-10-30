<?php

require_once "./model/Crud.php";

class Privilege extends Crud {
    public $table = "pweb_privilege";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "privilege"
    ];
}

?>