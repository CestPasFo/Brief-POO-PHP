<?php
namespace App\Controller;
use Service\matchSolver;

$allTypes = [];
$allPlayers = [];

function getAllInheriteds($base) {
    foreach(get_declared_classes() as $class) {
        if (is_subclass_of($class, $base)) {
            array_push($allTypes, $base);
        }
    }
}

getAllInheriteds($Player);

function championship () {
    foreach($allTypes as $class) {
    array_push($allPlayers, new $class);
}

$iteration = 0;

do {
    for ($i = 0; $i < count($allPlayers); $i++) {
        for ($j = $i + 1; $j < count($allPlayers); $j++) {

            $allPlayers[$i]->attack();
            $allPlayers[$j]->attack();

            matchSolver($allPlayers[$i], $allPlayers[$j], $iteration);
             
        }
    }
} while ($iteration < 10);
}

function setStats () {
    $sumCooperates;
    $sumCheats;

    $scoresByStrategy = []; // Keep this for later can be handy for other stats
    $playerTypesCount = []; // Stores the amount of each type: [string TypeName => int amount]

    foreach ($allPlayers as $player) {
        $last_score = null; // As we store the CURRENT score, we need to take away last round's score

        foreach ($player->getHistory() as $round) {
            $toAdd = $round["score"];
            if ($last_score !== null) { $toAdd -= $last_score; }
            
            $round["choice"] ? $sumCooperates += $toAdd : $sumCheats += $toAdd;

            $last_score = $round["score"];
        }

        $className = $player;
        if (isset($scoresByStrategy[$className])) { // Shouldn't need to check for $playerTypes
            $scoresByStrategy[$className] += $player->getScore();
            $playerTypesCount[$className] += 1;
        } else {
            $scoresByStrategy[$className] = $player->getScore();
            $playerTypesCount[$className] = 1;
        }
    }
    
    
    $averageScoresByStrategy = [];
    foreach ($scoresByStrategy as $playerType => $score) {
        $averageScoresByStrategy[$playerType] = $score / $playerTypesCount[$playerType];
    }

    /*
    TODO: Actually return, set a global, or show those variables:
    - $scoresByStrategy
    - $playerTypesCount
    - $averageScoresByStrategy

    Another interesting stat to know would be both sums of cheating and cooperating, maybe. Unsure.
    */
}
