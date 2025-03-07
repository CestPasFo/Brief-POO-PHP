<?php

namespace App\Entity;

/*
Overly defensive strategy
Betrays at first.
When betrayed, betrays back.
Randomly betays based on the average amount of betrayals of their opponent... And themselves.
*/
class PlayerParanoid extends Player {
    protected ?string $name = "Parano";
    
    public function attack() {
        if (empty($this->history) || !end($this->history)["opponentChoice"]) {
            $this->currentAttack = false;
        } else {
            $betrayals = 0;

            foreach ($this->history as $round) {
                $round["opponentChoice"] ? $betrayals++ : 0;
            }
            
            $this->currentAttack = rand(0, count($this->history)) < $betrayals;
        }
    }
}
