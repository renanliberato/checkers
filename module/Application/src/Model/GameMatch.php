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
        }, [Teams::B => 0, Teams::W => 0]);

        if ($checkersCount == $result[Teams::B])
            return MatchResult::LOSE;

        if ($checkersCount == $result[Teams::W])
            return MatchResult::WIN;

        return null;
    }

    public function aiMove() {
        if ($this->getTurn() != Teams::B)
            throw new \Exception("not AI's turn");
        
        $moves = $this->validator->generateMoves();
        $move = $moves[array_rand($moves, 1)];
        $from = $move->from;
        $to = $move->to;

        $moveResult = $this->validator->move($move);

        $this->board->possibleMoves = array_map(function($move) {
            return $move->from;
        }, $this->validator->generateMoves());

        if ($moveResult == null) {
            throw new \Exception('Invalid move');
        }

        $this->movements[] = ['from' => $from, 'to' => $to];
        $this->board->checkers[$to] = $this->board->checkers[$from];
        $this->board->checkers[$to]->position = $to;
        unset($this->board->checkers[$from]);

        foreach ($moveResult->takes as $takePosition) {
            unset($this->board->checkers[$takePosition]);
        }

        $this->board->fen = $this->validator->generateFen();
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
            throw new \Exception('Invalid move');
        }

        $this->movements[] = ['from' => $from, 'to' => $to];
        $this->board->checkers[$to] = $this->board->checkers[$from];
        $this->board->checkers[$to]->position = $to;
        unset($this->board->checkers[$from]);

        foreach ($moveResult->takes as $takePosition) {
            unset($this->board->checkers[$takePosition]);
        }

        $this->board->fen = $this->validator->generateFen();
    }

    public static function fromData($data) {
        $match = new GameMatch();
        $match->id = $data['id'];
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

        return $match;
    }

    public function jsonSerialize() {
        return [
            'board' => $this->board,
            'movements' => $this->movements,
        ];
    }

}
