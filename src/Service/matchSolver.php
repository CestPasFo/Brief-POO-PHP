<?php
namespace App\Service;

function matchSolver($player1, $player2, $iteration) {
    if ($player1->getCurrentAttack() == true && $player2->getCurrentAttack() == true) {
        $player1->SetScore += 3;
        $player2->SetScore += 3;
    } 
    else if ($player1->getCurrentAttack() == false && $player2->getCurrentAttack() == false) {
        $player1->SetScore += 1;
        $player2->SetScore += 1;
    } 
    else {
        if ( $player1->getCurrentAttack() == false ) {
            $player1->SetScore += 5;
        } else {
            $player2->SetScore += 5;
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