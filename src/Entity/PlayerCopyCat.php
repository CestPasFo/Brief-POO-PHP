<?php

namespace App\Entity;

class PlayerCopyCat extends Player {
    public function attack() {
        if (empty($this->$history)) {
            $this->$currentAttack = true;
        } else {
            $lastTurn = end($this->$history);
            $this->$currentAttack = $lastTurn["opponentChoice"];
        }
    }
}
