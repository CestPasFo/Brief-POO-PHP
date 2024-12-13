<?php

namespace App\Entity;

class PlayerAlwaysCooperate extends Player {
    protected ?string $name = "Altruiste (Always Coop)";

    public function attack() {
        $this->currentAttack =  true;
    }
}
