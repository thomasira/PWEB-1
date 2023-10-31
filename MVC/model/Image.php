<?php
require_once "./model/Crud.php";

class Image extends Crud {
    public $table = "pweb_image";
    public $primaryKey = "id";
    public $fillable = [
        "id",
        "image_link",
        "timbre_id",
        "principale"
    ];
}
?>