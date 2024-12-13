<?php

namespace App\Entity;

class PlayerForgivingCopycat extends Player {
    public function attack() {
        if (count($this->history) < 2) {
            $this->currentAttack = true;
        } else {
            $lastTurns = array_slice($this->history, -2);
            $this->currentAttack = $lastTurns[0]["opponentChoice"] || $lastTurns[1]["opponentChoice"];
        }
    }
}
