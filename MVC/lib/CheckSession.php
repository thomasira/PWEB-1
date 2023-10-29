<?php

class CheckSession {

    /**
     * vérifier la session et le privilège
     */
    static public function sessionAuth($level = null) {
        if(isset($_SESSION["fingerprint"]) && 
        $_SESSION["fingerprint"] == md5($_SERVER["HTTP_USER_AGENT"] . $_SERVER["REMOTE_ADDR"])) {
            if($level && $level < $_SESSION["privilege_id"]) RequirePage::redirect("error");
        } else RequirePage::redirect("login");
    }
}

//can probably check for privilege id as well, return id