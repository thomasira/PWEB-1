<?php
RequirePage::model("Condition");
RequirePage::model("Mise");
RequirePage::model("Timbre");
RequirePage::model("Membre");
RequirePage::model("Favori");
RequirePage::model("Mise");

class DataFiller {

    /**
     * remplir le tableau Enchere passé en param(incluant ses timbres, condition, mises, etc)
     */
    static public function getDataEnchere(&$enchere) {

        /* définir la cible enchere pour référence */  
        $where["target"] = "enchere_id";
        $where["value"] = $enchere["id"];

        /* lire le membre asocié */
        $membre = new Membre;
        $enchere["membre"] = $membre->readId($enchere["membre_id"]);

        /* chercher la meilleure mise et le nbr de mises*/
        $mise = new Mise;
        $what = "montant";
        $maxMise = $mise->readMax($what, $where);
        $nbrMises = $mise->readCount($what, $where);
        $enchere["nbr_mise"] = $nbrMises[0];
        if(empty($maxMise[0])) $enchere["max_mise"] = $enchere["prix_plancher"];
        else $enchere["max_mise"] = $maxMise["montant"];

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
        $nowDate = date_create(date("Y-m-d G:i"));
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

    /**
     * remplir le tableau Enchere passé en param d'une clé 'favori' si elle existe en DB pour le membre connecté
     */
    static public function checkFavori(&$enchere) {
        $favori = new Favori;
        $where["target"] = "membre_id";
        $where["value"] = $_SESSION["id"];
        $encheresFavoris = $favori->readWhere($where);
        if($encheresFavoris) {
            foreach ($encheresFavoris as $enchereFavori) {
                if($enchere["id"] == $enchereFavori["enchere_id"]) {
                    $enchere["favori"] = true;
                }
            }
        }

    }

    /**
     * remplir le tableau Enchere passé en param d'une clé 'mise' si elle existe en DB pour le membre connecté
     */
    static public function checkMises(&$enchere) {
        $mises = new Mise;
        $where["target"] = "membre_id";
        $where["value"] = $_SESSION["id"];
        $mises = $mises->readWhere($where);
        if($mises) {
            foreach ($mises as $mise) {
                if($enchere["id"] == $mise["enchere_id"]) {
                    $enchere["mise"] = true;
                }
            }
        }
    }

    /**
     * remplir le tableau Enchere passé en param d'une clé 'meneur' si elle existe en DB pour le membre connecté
     */
    static public function checkMeneur(&$enchere) {
        $mise = new Mise;
        $what = "montant";
        $where["target"] = "enchere_id";
        $where["value"] = $enchere["id"];

        $maxMise = $mise->readMax($what, $where);
        if($maxMise) {
            if($_SESSION["id"] == $maxMise["membre_id"]) $enchere["meneur"] = true;
        }
    }

    /**
     * simplifier la date de l'enchere passé en param pour format (Y)
     */
    static public function dateSimplify(&$date) {
        $date = explode('-', $date)[0];
    }
}
?>