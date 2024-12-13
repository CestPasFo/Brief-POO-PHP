<?php

namespace App\Entity;

class PlayerRandomBullshitGo extends Player {
    protected ?string $name = "Random Bullshit: GO !";
    
    public function attack() {
        $this->currentAttack = (bool) rand(0, 1);
    }
}
