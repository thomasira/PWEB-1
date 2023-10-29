<?php
require_once "./model/Crud.php";

class Stamp extends Crud {
    public $table = "pw2tp3_stamp";
    public $primaryKey = "id";
    public $fillable = [
        "id", 
        "name", 
        "description", 
        "origin", 
        "year", 
        "customer_user_id", 
        "aspect_id",
        "image_link"
    ];
}