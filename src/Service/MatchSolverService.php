<?php
namespace App\Service;

class MatchSolverService {
    function matchSolver($player1, $player2, $iteration) {
        if ($player1->getCurrentAttack() == true && $player2->getCurrentAttack() == true) {
            $player1->setScore(3 + $player1->getScore());
            $player2->setScore(3 + $player2->getScore());
        } 
        else if ($player1->getCurrentAttack() == false && $player2->getCurrentAttack() == false) {
            $player1->setScore(1 + $player1->getScore());
            $player2->setScore(1 + $player2->getScore());
        } 
        else {
            if ( $player1->getCurrentAttack() == false ) {
                $player1->setScore(5 + $player1->getScore());
            } else {
                $player2->setScore(5 + $player2->getScore());
            }
        }

        $player1->push(
            $iteration,
            $player1->getCurrentAttack(),
            $player2->getCurrentAttack(),
            $player1->getScore()
        );

        $player2->push(
            $iteration,
            $player2->getCurrentAttack(),
            $player1->getCurrentAttack(),
            $player2->GetScore()
        );
    }
}