<?php

namespace App\Entity;

class PlayerDumDum extends Player {
    public function attack() {
        if (empty($this->history)) {
            $this->currentAttack = true;
        } else {
            $lastTurn = end($this->history);
            $choice = $lastTurn["choice"];

            if (!$lastTurn["opponentChoice"]) {
                $choice = !$choice;
            }
            $this->currentAttack = $choice;
        }
    }
}
