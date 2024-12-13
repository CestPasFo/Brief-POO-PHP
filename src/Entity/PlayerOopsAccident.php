<?php

namespace App\Entity;

/*
Oops~ Accident~ Didn't me to~ Oh, sorry~ Won't happen again~ Silly me~ Missinput~ Lag~ Finger slipped~
Starts by cooperating thrice.
Betrays when betrayed more than once during the last three turns.
Betrays when opponent cooperated thrice in a row.
*/
class PlayerOopsAccident extends Player {
    public function attack() {
        if (count($this->history) < 3) {
            $this->currentAttack = true;
        } else {
            $betrayals = 0;
            $lastTurns = array_slice($this->history, -3);
            $choice = true;

            foreach ($lastTurns as $round) {
                $round["opponentChoice"] ?: $betrayals++;
            }
            $choice = $betrayals == 1;

            $this->currentAttack = $choice;
        }
    }
}
