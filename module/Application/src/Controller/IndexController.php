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
        $board = $this->getBoard();

        return new ViewModel([
            'board' => $board,
            'userTeam' => 1
        ]);
    }

    public function moveAction() {
        $curRow = $this->params()->fromQuery('currow');
        $curColumn = $this->params()->fromQuery('curcolumn');
        $row = $this->params()->fromQuery('row');
        $column = $this->params()->fromQuery('column');

        $board = $this->getBoard();
        
        if ($board->spaces[$row][$column]->checker == null) {
            $board->spaces[$row][$column]->checker = $board->spaces[$curRow][$curColumn]->checker;
            $board->spaces[$curRow][$curColumn]->checker = null;
            
            file_put_contents('./data/match.json', json_encode($board, JSON_PRETTY_PRINT));
        }
        
        $viewModel = new ViewModel([
            'board' => $board,
            'userTeam' => 1
        ]);
        
        $viewModel->setTerminal(true);
        
        return $viewModel;
    }

    private function getBoard() {
        $savedMatch = json_decode(file_get_contents('./data/match.json'), true);
        $board = new \Application\Model\Board();

        $board->spaces = $savedMatch['spaces'];

        foreach ($board->spaces as $rowKey => $row) {
            foreach ($row as $columnKey => $spaceData) {
                $board->spaces[$rowKey][$columnKey] = new \Application\Model\Space(
                        $spaceData['color'],
                        $spaceData['checker'] == null ? null : new \Application\Model\Checker($spaceData['checker']['color'], $spaceData['checker']['team'], $spaceData['checker']['id'])
                );
            }
        }
        
        return $board;
    }
}
