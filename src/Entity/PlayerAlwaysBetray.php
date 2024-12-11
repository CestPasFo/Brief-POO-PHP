<?php

namespace App\Entity;

class PlayerAlwaysBetray extends Player {
    public function attack() {
        $this->$currentAttack = false;
    }
}
