<?php

namespace App\Services;

use App\Entity\Fidelisation;

class GenerationPoints
{
    public function addPoints(Fidelisation $fidelisation, int $montant){
        if ($fidelisation->getPoints() == null){
            $point = 0;
        } else {
            $point = $fidelisation->getPoints();
        }

        if ($montant < 5000) {
            return $point + 1;
        }elseif ($montant >= 5000 and $montant < 10000){
            return $point + 2;
        }else{
            return $point + 3;
        }
    }

    public function removePoints(){
        return 0;
    }
}
