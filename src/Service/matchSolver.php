<?php
namespace App\Service;

function matchSolver($player1, $player2, $iteration) {
    if ($player1->getCurrentAttack == true && $player2->getCurrentAttack == true) {
        $player1->score += 3;
        $player2->score += 3;
    } 
    else if ($player1->getCurrentAttack == false && $player2->getCurrentAttack == false) {
        $player1->score += 1;
        $player2->score += 1;
    } 
    else {
        if ( $player1->getCurrentAttack == false ) {
            $player1->score += 5;
        } else {
            $player2->score += 5;
        }
    }

    $player1->push(array("turn"=>$iteration ,
                         "choice"=>$player1->getCurrentAttack,
                         "opponentchoice"=>$player2->getCurrentAttack,
                         "score"=>$player1->score ));
    $player2->push(array("turn"=>$iteration ,
                         "choice"=>$player2->getCurrentAttack,
                         "opponentchoice"=>$player1->getCurrentAttack,
                         "score"=>$player2->score ));
}