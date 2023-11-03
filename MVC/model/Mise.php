<?php
RequirePage::core("Crud");

class Mise extends Crud {
    public $table = "pweb_mise";
    public $primaryKeys = ["enchere_id", "membre_id","montant"];
    public $fillable = [
        "enchere_id",
        "membre_id",
        "date_mise",
        "montant"
    ];
}

?>