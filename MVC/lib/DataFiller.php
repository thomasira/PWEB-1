<?php

class DataFiller {

    static public function getDataEnchere(&$enchere) {
        RequirePage::library("DateChecker");
        RequirePage::model("Condition");
        RequirePage::model("Mise");
        RequirePage::model("Timbre");
        RequirePage::model("Image");

        /* définir la cible enchere pour référence */  
        $where["target"] = "enchere_id";
        $where["value"] = $enchere["id"];

        DateChecker::dateChecker($enchere);
        
        /* chercher la meilleure mise et le nbr de mises*/
        $mise = new Mise;
        $what = "montant";
        $maxMise = $mise->readMax($what, $where);
        $nbrMises = $mise->readCount($what, $where);

        $enchere["nbr_mise"] = $nbrMises[0];
        if(empty($maxMise[0])) $enchere["max_mise"] = $enchere["prix_plancher"];
        else $enchere["max_mise"] = $maxMise[0];
            
        /* chercher le/les timbres */
        $timbre = new Timbre;
        $encheresTimbres = $timbre->readWhere($where);
        $enchere["timbre"] = $encheresTimbres[0];
        $enchere["timbre"]["date_creation"] = explode('-', $enchere["timbre"]["date_creation"])[0];

        $condition = new Condition;
        $enchere["timbre"]["condition"] = $condition->readId($enchere["timbre"]["condition_id"]);
            
        /* chercher la premiere image associée du premier timbre */
        $image = new Image;

        $where["target"] = "timbre_id";
        $where["value"] = $enchere["timbre"]["id"];
        $enchere["images"] = $image->readWhere($where);
        
        if(!$enchere["images"]) {
            $enchere["image_princ"]["image_link"] = "default.svg";
        }
        else {
            foreach ($enchere["images"] as $image) {
                if($image["principale"]) $enchere["image_princ"] = $image;
                else $enchere["images_sec"][] = $image;
            }
        }
    }
}
?>