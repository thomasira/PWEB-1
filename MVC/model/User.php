<?php
require_once "./model/Crud.php";

class User extends Crud {
    public $table = "pw2tp3_user";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "name",
        "email",
        "password", 
        "address",
        "privilege_id"
    ];
}

?>