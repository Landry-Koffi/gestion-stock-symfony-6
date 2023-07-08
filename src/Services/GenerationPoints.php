<?php

namespace App\Services;

use App\Entity\Client;

class GenerationPoints
{
    public function addPoints(Client $client, int $montant){
        if ($montant < 5000) {
            return $client->getPoints() + 1;
        }elseif ($montant >= 5000 and $montant < 10000){
            return $client->getPoints() + 2;
        }else{
            return $client->getPoints() + 3;
        }
    }

    public function removePoints(){
        return 0;
    }
}
