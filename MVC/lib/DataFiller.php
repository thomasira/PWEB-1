<?php

class DataFiller {

    /**
     * remplir le tableau Enchere passé en param(incluant ses timbres, condition, mises, etc)
     */
    static public function getDataEnchere(&$enchere) {
        RequirePage::model("Condition");
        RequirePage::model("Mise");
        RequirePage::model("Timbre");
        RequirePage::model("Membre");

        /* définir la cible enchere pour référence */  
        $where["target"] = "enchere_id";
        $where["value"] = $enchere["id"];

        $membre = new Membre;
        $enchere["membre"] = $membre->readId($enchere["membre_id"]);

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

        $condition = new Condition;
        $enchere["timbre"]["condition"] = $condition->readId($enchere["timbre"]["condition_id"]);
            
        DataFiller::getImages($enchere);
        DataFiller::dateChecker($enchere);
    }

    /**
     * remplir le tableau Enchere passé en param avec les images associées à ses timbres
     */
    public static function getImages(&$enchere) {
        RequirePage::model("Image");

        $image = new Image;
        $where["target"] = "timbre_id";
        $where["value"] = $enchere["timbre"]["id"];
        $images = $image->readWhere($where);
        
        if(!$images) {
            $enchere["image_princ"]["image_link"] = "default.svg";
        }
        else {
            foreach ($images as $image) {
                if($image["principale"]) $enchere["image_princ"] = $image;
                else $enchere["images_sec"][] = $image;
            }
        }
    }

    /**
     * remplir le tableau Enchere passé en param avec des détails concernant ses dates
     */
    static public function dateChecker(&$enchere) {
        $endDate = date_create($enchere["date_fin"]);
        $startDate = date_create($enchere["date_debut"]);
        $nowDate = date_create(date("Y-m-d h:i"));
        $dateDiff = date_diff($nowDate, $endDate);
        if($startDate > $nowDate) {
            $dateDiff = date_diff($startDate, $nowDate);   
            $enchere["status"] = "a_venir";
        } elseif($endDate < $nowDate) $enchere["status"] = "passe";
        else $enchere["status"] = "en_cours";

        $enchere["date_diff"]["d"] = $dateDiff->format("%a");
        $enchere["date_diff"]["h"] = $dateDiff->format("%H");
        $enchere["date_diff"]["i"] = $dateDiff->format("%I");
    }

    static public function dateSimplify(&$date) {
        $date = explode('-', $date)[0];
    }
}
?>