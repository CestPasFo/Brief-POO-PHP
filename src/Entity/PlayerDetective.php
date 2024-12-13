<?php

namespace App\Entity;

class PlayerDetective extends Player {
    public function attack() {
        switch (count($this->history)) {
            // Set moves
            case 0: $this->currentAttack = true; break;
            case 1: $this->currentAttack = false; break;
            case 2: $this->currentAttack = true; break;
            case 3: $this->currentAttack = true; break;
            // Now has logic
            
            default:
                // Checks if the opponent is forgiving
                $isExploitable = true;
            
                for ($i = 0; $i < 4; $i++) {
                    $isExploitable = $isExploitable && $this->history[$i]["opponentChoice"];
                }
                
                if ($isExploitable) {
                    $this->currentAttack = false;
                } else {
                    // Acts like Copycat
                    $lastTurn = end($this->history);
                    $this->currentAttack = $lastTurn["opponentChoice"];
                }
                break;
        }
    }
}
