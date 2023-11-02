<?php
RequirePage::model("Enchere");
RequirePage::model("Timbre");
RequirePage::model("Image");
RequirePage::model("Mise");
RequirePage::model("Condition");

class GetEnchere {
    // envoyer dans modele enchere
    
    public static function getAll(&$enchere) {

        /* définir la cible enchere pour référence */  
        $where["target"] = "enchere_id";
        $where["value"] = $enchere["id"];

        /* définir le temps restant ou à venir */
        $endDate = date_create($enchere["date_fin"]);
        $startDate = date_create($enchere["date_debut"]);
        $nowDate = date_create(date("Y-m-d h:i"));
        $dateDiff = date_diff($nowDate, $endDate);

        if($startDate > $nowDate) {
            $enchere["status"] = "a_venir";
            $dateDiff = date_diff($startDate, $nowDate);   
        } elseif($endDate < $nowDate) $enchere["status"] = "passe";
        else $enchere["status"] = "en_cours";
        
        $enchere["date_diff"]["d"] = $dateDiff->format("%a");
        $enchere["date_diff"]["h"] = $dateDiff->format("%H");
        $enchere["date_diff"]["i"] = $dateDiff->format("%I");

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
        $enchere["image"] = $image->readId($enchere["timbre"]["id"]);
        if(!$enchere["image"]["image_link"]) {
            $enchere["image"]["image_link"] = "default.svg";
        }
    }
}

?>