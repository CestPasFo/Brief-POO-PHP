<?php

namespace App\Entity;

class PlayerAlwaysBetray extends Player {
    protected ?string $name = "Égoïste (Always Cheat)";

    public function attack() {
        $this->currentAttack = false;
    }
}
