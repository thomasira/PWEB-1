<?php
RequirePage::core("Crud");

class Favori extends Crud {
    public $table = "pweb_enchere_favori";
    public $primaryKeyEnchere = "enchere_id";
    public $primaryKeyMembre = "membre_id";
    public $fillable = [
        "enchere_id",
        "membre_id"
    ];


    public function delete($data) {
        $enchereId = $data["enchere_id"];
        $membreId = $data["membre_id"];
        $sql = "DELETE FROM $this->table WHERE $this->primaryKeyEnchere = :$this->primaryKeyEnchere
        AND $this->primaryKeyMembre = :$this->primaryKeyMembre";
        $query = $this->prepare($sql);
        $query->bindValue(":$this->primaryKeyMembre", $membreId);
        $query->bindValue(":$this->primaryKeyEnchere", $enchereId);

        if($query->execute()) return true;
        else return $query->errorInfo(); 
    }
}
?>
