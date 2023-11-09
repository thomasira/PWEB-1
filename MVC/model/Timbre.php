<?php
RequirePage::core("Crud");

class Timbre extends Crud {
    public $table = "pweb_timbre";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "nom_timbre",
        "date_creation",
        "pays_origine",
        "certifie",
        "couleur",
        "tirage",
        "enchere_id",
        "condition_id",
        "membre_id"
    ];
}

?>