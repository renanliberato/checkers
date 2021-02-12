<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    private $matchRepository;
    
    public function __construct(\Application\Repository\GameMatchRepositoryInterface $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }
    
    public function indexAction() {
        $matchId = $this->params()->fromQuery('match');

        if (!$matchId) {
            return $this->redirect()->toUrl('/checkers/application/index/new');
        }

        $match = $this->matchRepository->get($matchId);
        
        if ($match->getTurn() == 'b'){
            $match->aiMove();
            $this->matchRepository->save($match);
        }

        return new \Application\ViewModel\MatchViewModel($match);
    }

    public function aimoveAction() {
        $matchId = $this->params()->fromQuery('match');

        if (!$matchId) {
            return $this->redirect()->toUrl('/checkers/application/index/new');
        }

        $match = $this->matchRepository->get($matchId);
        
        $match->aiMove();
        $this->matchRepository->save($match);
        
        $viewModel = new \Application\ViewModel\MatchViewModel($match);

        $viewModel->setTerminal(true);

        return $viewModel;
    }
    
    public function moveAction() {
        $from = (int) $this->params()->fromQuery('curposition');
        $to = (int) $this->params()->fromQuery('position');
        $matchId = $this->params()->fromQuery('match');

        if (!$matchId) {
            return $this->redirect()->toUrl('/checkers/application/index/new');
        }

        $match = $this->matchRepository->get($matchId);

        $match->move($from, $to);
        $this->matchRepository->save($match);

        $viewModel = new \Application\ViewModel\MatchViewModel($match);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function newAction() {
        $match = \Application\Model\GameMatch::create();
        $this->matchRepository->save($match);

        return $this->redirect()->toUrl('/checkers/?match=' . $match->getId());
    }

}
