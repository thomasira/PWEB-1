<?php
require_once "./model/Crud.php";

class Timbre extends Crud {
    public $table = "pweb_timbre";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "nom_timbre",
        "date_creation",
        "pays_origine",
        "certifie",
        "tirage",
        "enchere_id",
        "condition_id",
        "membre_id"
    ];
}

?>