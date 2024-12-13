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

class championshipController extends AbstractController
{
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
            PlayerRandomBullshitGo::class
        ];
    }

    private function championship()
    {
        foreach($this->allTypes as $class) {
            $this->allPlayers[] = new $class();
        }

        
        for ($i = 0; $i < count($this->allPlayers); $i++) {
            for ($j = $i + 1; $j < count($this->allPlayers); $j++) {
                for ($iteration = 0; $iteration < 10; $iteration++) {
                    $this->allPlayers[$i]->attack();
                    $this->allPlayers[$j]->attack();

                    $this->matchSolver->matchSolver($this->allPlayers[$i], $this->allPlayers[$j], $iteration);
                    
                    $this->matches[] = [
                        'player1' => get_class($this->allPlayers[$i]),
                        'player2' => get_class($this->allPlayers[$j]),
                        'result' => [
                            'player1Score' => $this->allPlayers[$i]->getScore(),
                            'player2Score' => $this->allPlayers[$j]->getScore()
                        ],
                        'iteration' => $iteration
                    ];                    
                }
            }
        }
    }

    private function setStats()
    {
        foreach ($this->allPlayers as $player) {
            $last_score = null;

            foreach ($player->getHistory() as $round) {
                $toAdd = $round["score"];
                if ($last_score !== null) {
                    $toAdd -= $last_score;
                }
                
                if ($round["choice"]) {
                    $this->sumCooperates += $toAdd;
                } else {
                    $this->sumCheats += $toAdd;
                }

                $last_score = $round["score"];
            }

            $className = get_class($player);
            if (isset($this->scoresByStrategy[$className])) {
                $this->scoresByStrategy[$className] += $player->getScore();
                $this->playerTypesCount[$className] += count($player->getHistory());
            } else {
                $this->scoresByStrategy[$className] = $player->getScore();
                $this->playerTypesCount[$className] = count($player->getHistory());
            }
        }
        
        foreach ($this->scoresByStrategy as $playerType => $score) {
            $this->averageScoresByStrategy[$playerType] = $score / $this->playerTypesCount[$playerType];
        }
    }
}
