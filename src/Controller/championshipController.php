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

    //logic to be added to set the values ;)

    $averageScoresByStrategy;


}