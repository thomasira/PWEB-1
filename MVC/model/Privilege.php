<?php
RequirePage::core("Crud");

class Privilege extends Crud {
    public $table = "pweb_privilege";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "privilege"
    ];
}

?>