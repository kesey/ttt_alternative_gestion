<?php

/* 
 * AUTEUR: Fabien Meunier
 * PROJECT: Third_Type_Tapes
 * PATH: Third_Type_Tapes/model/
 * NAME: admin.php
 */

class Admin extends Model{
    public $id;
    var $table = "admin";
    
    // utile pour ne pas prendre en compte les lignes archivées
    var $notArchive = "suppr != 1";
    
    // nom de la colonne servant à stocker les mots de passe dans la table
    var $psw = "mot_de_passe";

   /**
    *  vérifie la/les donnée(s) passée(s) en argument
    *  @param array $data donnée(s) à vérifier
    **/
    public function verifications($data) {               
        $isOk = TRUE;
        if(empty($data["nom"])){
            $_SESSION["info"] = "Veuillez renseigner un nom";
            $isOk = FALSE;
        } 
        if(empty($data["identifiant"])){
            $_SESSION["info"] = "Veuillez renseigner un identifiant";
            $isOk = FALSE;
        } else if(empty($data['id_admin'])){
            if($this->exist('identifiant', $data["identifiant"])){
                $_SESSION["info"] = "Cet identifiant existe déjà";
                $isOk = FALSE;
            }
        }
        if(empty($data["mot_de_passe"])){
            $_SESSION["info"] = "Veuillez renseigner un mot de passe";
            $isOk = FALSE;
        } else if(empty($data['id_admin'])){
            $exist = FALSE;
            $tabPsw = $this->findAll(array("fields" => "mot_de_passe"));
            foreach ($tabPsw as $value) {
                if(password_verify($data["mot_de_passe"], $value["mot_de_passe"])){
                    $exist = TRUE;
                }
            }
            if($exist){
                $_SESSION["info"] = "Ce mot de passe existe déjà";
                $isOk = FALSE;
            }
        }
        return $isOk;
    }
}

