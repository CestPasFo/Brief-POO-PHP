<?php

namespace App\Entity;

class Player {
    public int $score = 0;
    private bool $currentAttack = true;
    private array $history =  [];

    public function attack() { }

    public function getCurrentAttack() : bool
    {
        return $currentAttack;
    }

    public function getHistory() : array
    {
        return $history;
    }

    public function push(array $entry) {
        array_push($history, $entry);
    }
}
