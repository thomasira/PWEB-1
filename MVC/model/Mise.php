<?php
require_once "./model/Crud.php";

class Mise extends Crud {
    public $table = "pweb_mise";
    public $primaryKeys = ["enchere_id", "membre_id"];
    public $fillable = [
        "enchere_id",
        "membre_id",
        "date_mise",
        "montant"
    ];
}

?>