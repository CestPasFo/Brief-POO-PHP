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

    public function push(int $turn, bool $choice, bool $opponentChoice, int $score) {
        array_push(
            $this->history,
            [
                "turn" => $turn,
                "choice" => $choice,
                "opponentChoice" => $opponentChoice,
                "score" => $score
            ]
        );
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($newScore) {
        $this->score = $newScore;
    }
}
