<?php
namespace App\Service;

function matchSolver($player1, $player2, $iteration) {
    if ($player1->getCurrentAttack() == true && $player2->getCurrentAttack() == true) {
        $player1->SetScore() += 3;
        $player2->SetScore() += 3;
    } 
    else if ($player1->getCurrentAttack() == false && $player2->getCurrentAttack() == false) {
        $player1->SetScore() += 1;
        $player2->SetScore() += 1;
    } 
    else {
        if ( $player1->getCurrentAttack() == false ) {
            $player1->SetScore() += 5;
        } else {
            $player2->SetScore() += 5;
        }
    }

    $player1->push(array("turn"=>$iteration ,
                         "choice"=>$player1->getCurrentAttack(),
                         "opponentchoice"=>$player2->getCurrentAttack(),
                         "score"=>$player1->SetScore() ));
    $player2->push(array("turn"=>$iteration ,
                         "choice"=>$player2->getCurrentAttack(),
                         "opponentchoice"=>$player1->getCurrentAttack(),
                         "score"=>$player2->SetScore() ));
}