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
        $from = (int) $this->params()->fromQuery('curposition');
        $to = (int) $this->params()->fromQuery('position');

        $board = $this->getBoard();

        $move = new \Photogabble\Draughts\Move();
        $move->from = $from;
        $move->to = $to;

        $moveResult = $board->validator->move($move);
        
        $board->possibleMoves = array_map(function($move) {
            return $move->from;
        }, $board->validator->generateMoves());
        
        if ($moveResult != null) {
            $board->checkers[$to] = $board->checkers[$from];
            $board->checkers[$to]->position = $to;
            unset($board->checkers[$from]);

            foreach ($moveResult->takes as $takePosition) {
                unset($board->checkers[$takePosition]);
            }
            
            file_put_contents('./data/fen.txt', $board->validator->generateFen());
            file_put_contents('./data/checkers.json', json_encode($board->checkers, JSON_PRETTY_PRINT));
        }

        $viewModel = new ViewModel([
            'board' => $board,
            'userTeam' => 1
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function newAction() {
        $this->createBoard();
        
        return $this->redirect()->toUrl('/');
    }

    private function getAsciiBoard() {
        $board = new \Photogabble\Draughts\Draughts(file_get_contents('./data/fen.txt'));

        return $board;
    }

    private function getBoard() {
        $board = new \Application\Model\Board();
        $board->validator = $this->getAsciiBoard();
        $checkersJson = json_decode(file_get_contents('./data/checkers.json'), true);

        $board->possibleMoves = array_map(function($move) {
            return $move->from;
        }, $board->validator->generateMoves());
        
        foreach (array_values($checkersJson) as $checker) {
            $board->checkers[$checker['position']] = new \Application\Model\Checker($checker['color'], $checker['id'], $checker['position']);
        }

        return $board;
    }

    private function createBoard() {
        $board = new \Application\Model\Board();
        $board->validator = new \Photogabble\Draughts\Draughts();

        array_map(function ($i) use ($board) {
            $board->checkers[$i] = new \Application\Model\Checker('black', \Ramsey\Uuid\Uuid::uuid4()->toString(), $i);
        }, range(1, 20));

        array_map(function ($i) use ($board) {
            $board->checkers[$i] = new \Application\Model\Checker('white', \Ramsey\Uuid\Uuid::uuid4()->toString(), $i);
        }, range(31, 50));

        file_put_contents('./data/fen.txt', $board->validator->generateFen());
        file_put_contents('./data/checkers.json', json_encode($board->checkers, JSON_PRETTY_PRINT));

        return $board;
    }

}
