<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of Match
 *
 * @author renan
 */
class GameMatch implements \JsonSerializable {

    /**
     * @var string
     */
    private $id;

    /**
     * 
     * @var array
     */
    private $movements;

    /**
     * 
     * @var Board
     */
    private $board;

    /**
     * 
     * @var \Photogabble\Draughts\Draughts
     */
    private $validator;

    public function __construct() {
        $this->id = (\Ramsey\Uuid\Uuid::uuid4())->toString();
        $this->movements = [];
    }

    public function getId() {
        return $this->id;
    }

    public function getTurn() {
        return $this->validator->turn();
    }

    public function getCheckers() {
        return $this->board->checkers;
    }

    public function getPossibleMoves() {
        return $this->board->possibleMoves;
    }

    public function getMovements() {
        return $this->movements;
    }

    public function getResult() {
        $checkers = $this->getCheckers();
        $checkersCount = count($checkers);

        $result = array_reduce($checkers, function($res, $checker) {
            $res[$checker->team]++;

            return $res;
        }, ['b' => 0, 'w' => 0]);

        if ($checkersCount == $result['b'])
            return 'lose';

        if ($checkersCount == $result['w'])
            return 'win';

        return null;
    }

    public function aiMove() {
        $moves = $this->validator->generateMoves();
        $move = $moves[array_rand($moves, 1)];
        $from = $move->from;
        $to = $move->to;

        $moveResult = $this->validator->move($move);

        $this->board->possibleMoves = array_map(function($move) {
            return $move->from;
        }, $this->validator->generateMoves());

        if ($moveResult == null) {
            return false;
        }

        $this->movements[] = ['from' => $from, 'to' => $to];
        $this->board->checkers[$to] = $this->board->checkers[$from];
        $this->board->checkers[$to]->position = $to;
        unset($this->board->checkers[$from]);

        foreach ($moveResult->takes as $takePosition) {
            unset($this->board->checkers[$takePosition]);
        }

        $this->board->fen = $this->validator->generateFen();

        file_put_contents('./data/match_' . $this->id . '.json', json_encode($this));

        return true;
    }

    public function move($from, $to) {
        $move = new \Photogabble\Draughts\Move();
        $move->from = $from;
        $move->to = $to;

        $moveResult = $this->validator->move($move);

        $this->board->possibleMoves = array_map(function($move) {
            return $move->from;
        }, $this->validator->generateMoves());

        if ($moveResult == null) {
            return false;
        }

        $this->movements[] = ['from' => $from, 'to' => $to];
        $this->board->checkers[$to] = $this->board->checkers[$from];
        $this->board->checkers[$to]->position = $to;
        unset($this->board->checkers[$from]);

        foreach ($moveResult->takes as $takePosition) {
            unset($this->board->checkers[$takePosition]);
        }

        $this->board->fen = $this->validator->generateFen();

        file_put_contents('./data/match_' . $this->id . '.json', json_encode($this));

        return true;
    }

    public static function get($id) {
        $file = './data/match_' . $id . '.json';
        if (!file_exists($file)) {
            throw new Exception("Match not found");
        }

        $data = json_decode(file_get_contents($file), true);

        $match = new GameMatch();
        $match->id = $id;
        $match->validator = new \Photogabble\Draughts\Draughts($data['board']['fen']);
        $board = new \Application\Model\Board();
        $board->fen = $data['board']['fen'];

        $board->possibleMoves = array_map(function($move) {
            return $move->from;
        }, $match->validator->generateMoves());

        foreach (array_values($data['board']['checkers']) as $checker) {
            $board->checkers[$checker['position']] = new \Application\Model\Checker($checker['color'], $checker['id'], $checker['position']);
        }
        $match->board = $board;
        $match->movements = $data['movements'];

        if ($match->getTurn() == 'b')
            $match->aiMove();
        
        return $match;
    }

    public static function create() {
        $match = new GameMatch();
        $match->validator = new \Photogabble\Draughts\Draughts();

        $board = new \Application\Model\Board();
        $board->fen = $match->validator->generateFen();

        array_map(function ($i) use ($board) {
            $board->checkers[$i] = new \Application\Model\Checker('black', \Ramsey\Uuid\Uuid::uuid4()->toString(), $i);
        }, range(1, 20));

        array_map(function ($i) use ($board) {
            $board->checkers[$i] = new \Application\Model\Checker('white', \Ramsey\Uuid\Uuid::uuid4()->toString(), $i);
        }, range(31, 50));

        $match->board = $board;

        file_put_contents('./data/match_' . $match->id . '.json', json_encode($match));

        return $match;
    }

    public function jsonSerialize() {
        return [
            'board' => $this->board,
            'movements' => $this->movements,
        ];
    }

}
