<?php

namespace PlatBundle\Repository;
use Doctrine\ORM\Query\ResultSetMapping;
use PlatBundle\Controller\PlatController;
use PlatBundle\Entity\Plat;

/**
 * PlatRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlatRepository extends \Doctrine\ORM\EntityRepository
{
    public function chaine($input){
        $string= "";
        $isEmpty = true;
        foreach ($input as $key => $value) {
            if(! is_null($value)){
                $string.="'$key'".",";
                $isEmpty=false ;
            }
        }

        if($isEmpty){
            foreach ($input as $key => $value) {
                $string.="'$key'".",";

            }
        }
        $string = rtrim($string, ",");
        return $string ;
    }

    public function chaineMeteo($input){
        $string ="";
        if ($input["cold"]=="on")
            $string.="'cold'";
        else if ($input["hot"]=='on')
            $string.="'hot'";
        else
            $string.="'all'";
        return $string;
    }



    public function AdvSearchPlat($formulaireData){
        $conn = $this->getEntityManager()->getConnection();
        if($formulaireData[5]=='on') $hfr=3 ; else $hfr=0 ;

        $sql="select plat.id  from plat where (
type in(SELECT id from typeplat WHERE nom in(".$this->chaine($formulaireData[4]).") )
AND
specialite in (SELECT id from specialite where nom in (".$this->chaine($formulaireData[2])."))
AND
tempsPrepa+tempsCuisson <= ".($formulaireData[3])["ttotal"]."
AND
hfr>=". $hfr ."
AND
meteo=".$this->chaineMeteo($formulaireData[0])."
AND
plat.id in (SELECT id from humeur_plat where (humeur_plat.humeur_id in (select id from humeur where humeur.nom in(".$this->chaine($formulaireData[1]).")) ))

    )
 LIMIT 3;";
        //dump($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetchAll();
        //dump(count($fetch));
        return array(count($fetch),$fetch);
    }





}
