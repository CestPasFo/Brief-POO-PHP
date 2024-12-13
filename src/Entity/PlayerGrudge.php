<?php

namespace App\Entity;

class PlayerGrudge extends Player {
    public function attack() {
        if (empty($this->history)) {
            $this->currentAttack = true;
        } else {
            $choice = true;

            foreach ($this->history as $round) {
                $choice = $choice && $round["opponentChoice"];
            }
            
            $this->currentAttack = $choice;
        }
    }
}
