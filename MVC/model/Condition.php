<?php
require_once "./model/Crud.php";

class Condition extends Crud {
    public $table = "pweb_condition";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "condition"
    ];
}

?>