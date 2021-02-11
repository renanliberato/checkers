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

    private $fen;
    private $movements;
    private $checkers;
    private $validator;

    public static function create() {
        $match = new GameMatch();
    }

    public function jsonSerialize() {
        return [
            'fen' => $this->fen,
            'movements' => $this->movements,
            'checkers' => $this->checkers
        ];
    }

}
