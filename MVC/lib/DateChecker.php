<?php

class DateChecker {
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
}
?>