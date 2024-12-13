<?php

namespace App\Entity;

// Increasingly likely to betray over long periods. Doesn't care about getting betrayed.
class PlayerCashout extends Player {
    protected ?string $name = "Cashout";
    
    public function attack() {
        $this->currentAttack = rand(0, count($this->history)+1) == 0;
    }
}
