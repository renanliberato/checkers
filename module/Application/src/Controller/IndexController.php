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

    public function indexAction() {
        $matchId = $this->params()->fromQuery('match');

        if (!$matchId) {
            return $this->redirect()->toUrl('/application/index/new');
        }

        $match = \Application\Model\GameMatch::get($matchId);
        
        if ($match->getTurn() == 'b')
            $match->aiMove();

        return new ViewModel([
            'turn' => $match->getTurn(),
            'match' => $match,
            'userTeam' => 1,
            'movements' => $match->getMovements()
        ]);
    }

    public function aimoveAction() {
        $matchId = $this->params()->fromQuery('match');

        if (!$matchId) {
            return $this->redirect()->toUrl('/application/index/new');
        }

        $match = \Application\Model\GameMatch::get($matchId);
        
        $match->aiMove();
        
        $viewModel = new ViewModel([
            'turn' => $match->getTurn(),
            'match' => $match,
            'userTeam' => 1,
            'movements' => $match->getMovements()
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }
    
    public function moveAction() {
        $from = (int) $this->params()->fromQuery('curposition');
        $to = (int) $this->params()->fromQuery('position');
        $matchId = $this->params()->fromQuery('match');

        if (!$matchId) {
            return $this->redirect()->toUrl('/application/index/new');
        }

        $match = \Application\Model\GameMatch::get($matchId);

        if (!$match->move($from, $to)) {
            throw new \Exception('Invalid move');
        }

        $viewModel = new ViewModel([
            'turn' => $match->getTurn(),
            'match' => $match,
            'userTeam' => 1,
            'movements' => $match->getMovements()
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function newAction() {
        $match = \Application\Model\GameMatch::create();

        return $this->redirect()->toUrl('/?match=' . $match->getId());
    }

}
