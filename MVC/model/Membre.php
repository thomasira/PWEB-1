<?php
require_once "./model/Crud.php";

class Membre extends Crud {
    public $table = "pweb_membre";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "nom_membre",
        "email",
        "password",
        "privilege_id"
    ];
}
?>