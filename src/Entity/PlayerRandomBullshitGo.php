<?php

namespace App\Entity;

class PlayerRandomBullshitGo extends Player {
    public function attack() {
        $this->$currentAttack =  rand(0, 1);
    }
}
