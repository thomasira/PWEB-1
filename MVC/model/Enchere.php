<?php
require_once "./model/Crud.php";

class Enchere extends Crud {
    public $table = "pweb_enchere";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "enchere_nom",
        "date_debut",
        "date_fin",
        "prix_plancher",
        "coups_de_coeur",
        "membre_id"
    ];
}

?>