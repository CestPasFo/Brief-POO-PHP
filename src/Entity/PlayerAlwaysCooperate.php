<?php

namespace App\Entity;

class PlayerAlwaysCooperate extends Player {
    public function attack() {
        $this->currentAttack =  true;
    }
}
