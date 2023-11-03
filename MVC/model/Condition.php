<?php
RequirePage::core("Crud");

class Condition extends Crud {
    public $table = "pweb_condition";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "condition"
    ];
}

?>