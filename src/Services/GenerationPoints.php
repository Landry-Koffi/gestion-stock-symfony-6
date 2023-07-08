<?php

namespace App\Services;

use App\Entity\Client;

class GenerationPoints
{
    public function addPoints(Client $client, int $montant){
        if ($client->getPoints() == null){
            $point = 0;
        } else {
            $point = $client->getPoints();
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
