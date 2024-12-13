<?php
namespace App\Controller;

use App\Service\MatchSolverService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Player;
use App\Entity\PlayerAlwaysBetray;
use App\Entity\PlayerAlwaysCooperate;
use App\Entity\PlayerCopyCat;
use App\Entity\PlayerRandomBullshitGo;
use App\Entity\PlayerGrudge;
use App\Entity\PlayerDetective;
use App\Entity\PlayerForgivingCopycat;
use App\Entity\PlayerDumDum;
use App\Entity\PlayerParanoid;
use App\Entity\PlayerCashout;

class championshipController extends AbstractController
{
    // "Config"
    private $roundCount = 10;

    // Variables
    private $matchSolver;
    private $allTypes = [];
    private $allPlayers = [];
    private $sumCooperates = 0;
    private $sumCheats = 0;
    private $scoresByStrategy = [];
    private $playerTypesCount = [];
    private $averageScoresByStrategy = [];
    private $matches = [];

    public function __construct(MatchSolverService $matchSolver)
    {
        $this->matchSolver = $matchSolver;
    }

    #[Route('/tournament', name: 'tournament')]
    public function index(): Response
    {
        $this->getAllInheriteds(Player::class);
        $this->championship();
        $this->setStats();

        return $this->render('championship/index.html.twig', [
            'players' => $this->allPlayers,
            'scoresByStrategy' => $this->scoresByStrategy,
            'averageScoresByStrategy' => $this->averageScoresByStrategy,
            'matches' => $this->matches,
            'sumCooperates' => $this->sumCooperates,
            'sumCheats' => $this->sumCheats
        ]);              
    }

    private function getAllInheriteds($base)
    {
        $this->allTypes = [
            PlayerAlwaysBetray::class,
            PlayerAlwaysCooperate::class,
            PlayerCopyCat::class,
            PlayerRandomBullshitGo::class,
            PlayerGrudge::class,
            PlayerDetective::class,
            PlayerForgivingCopycat::class,
            PlayerDumDum::class,
            PlayerParanoid::class,
            PlayerCashout::class
        ];
    }

    private function championship()
    {
        foreach($this->allTypes as $class) {
            $this->allPlayers[] = new $class();
        }

        
        for ($i = 0; $i < count($this->allPlayers); $i++) {
            for ($j = $i + 1; $j < count($this->allPlayers); $j++) {
                $p1LastMatchScore = $this->allPlayers[$i]->getScore();
                $p2LastMatchScore = $this->allPlayers[$j]->getScore();

                // Begin match
                for ($iteration = 0; $iteration < $this->roundCount; $iteration++) {
                    // TODO: Match solver prevents having one clean foreach. Find a workaround.
                    $this->allPlayers[$i]->attack();
                    $this->allPlayers[$j]->attack();

                    $p1LastScore = $this->allPlayers[$i]->getScore();
                    $p2LastScore = $this->allPlayers[$j]->getScore();


                    $this->matchSolver->matchSolver($this->allPlayers[$i], $this->allPlayers[$j], $iteration);


                    $p1Score = $this->allPlayers[$i]->getScore();
                    $p2Score = $this->allPlayers[$j]->getScore();
                    $p1Choice = $this->allPlayers[$i]->getCurrentAttack();
                    $p2Choice = $this->allPlayers[$j]->getCurrentAttack();

                    $p1Choice ? $this->sumCooperates += $p1Score - $p1LastScore : $this->sumCheats += $p1Score - $p1LastScore;
                    $p2Choice ? $this->sumCooperates += $p2Score - $p2LastScore : $this->sumCheats += $p2Score - $p2LastScore;

                    
                    $this->matches[] = [
                        'player1' => get_class($this->allPlayers[$i]),
                        'player2' => get_class($this->allPlayers[$j]),
                        'result' => [
                            'player1Score' => $p1Score,
                            'player2Score' => $p2Score
                        ],
                        'iteration' => $iteration
                    ];
                }

                $className = get_class($this->allPlayers[$i]);
                if (isset($this->scoresByStrategy[$className])) {
                    $this->scoresByStrategy[$className] += $this->allPlayers[$i]->getScore() - $p1LastMatchScore;
                    $this->playerTypesCount[$className] += $this->roundCount;
                } else {
                    $this->scoresByStrategy[$className] = $this->allPlayers[$i]->getScore() - $p1LastMatchScore;
                    $this->playerTypesCount[$className] = $this->roundCount;
                }

                $className = get_class($this->allPlayers[$j]);
                if (isset($this->scoresByStrategy[$className])) {
                    $this->scoresByStrategy[$className] += $this->allPlayers[$j]->getScore() - $p2LastMatchScore;
                    $this->playerTypesCount[$className] += $this->roundCount;
                } else {
                    $this->scoresByStrategy[$className] = $this->allPlayers[$j]->getScore() - $p2LastMatchScore;
                    $this->playerTypesCount[$className] = $this->roundCount;
                }

                $this->allPlayers[$i]->resetHistory();
                $this->allPlayers[$j]->resetHistory();
            }
        }
    }

    private function setStats()
    {
        foreach ($this->scoresByStrategy as $playerType => $score) {
            $this->averageScoresByStrategy[$playerType] = $score / $this->playerTypesCount[$playerType];
        }
    }
}
