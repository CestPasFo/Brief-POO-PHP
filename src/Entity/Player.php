<?php

namespace App\Entity;

abstract class Player {
    public int $score = 0;
    protected bool $currentAttack = true;
    protected array $history =  [];

    public function attack() { }

    public function getCurrentAttack() : bool
    {
        return $this->currentAttack;
    }

    public function getHistory() : array
    {
        return $this->history;
    }

    public function push(array $entry) {
        array_push($history, $entry);
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($newScore) {
        $this->score = $newScore;
    }
}
