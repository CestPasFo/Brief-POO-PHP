<?php

namespace App\Entity;

class PlayerRandomBullshitGo extends Player {
    public function attack() {
        $this->currentAttack = (bool) rand(0, 1);
    }
}
