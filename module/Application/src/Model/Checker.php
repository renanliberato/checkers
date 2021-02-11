<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of Checker
 *
 * @author renan
 */
class Checker {

    public $team;
    public $color;
    public $id;
    public $position;
    public $canMoveTo;

    public function __construct($color, $id, $position) {
        $this->id = $id == null ? (\Ramsey\Uuid\Uuid::uuid4())->toString() : $id;
        $this->color = $color;
        $this->team = $color[0];
        $this->position = $position;
    }

    public function updatePossibleMovements($board) {
        $this->canMoveTo = $this->getPossibleMovements($board);
    }

    private function getPossibleMovements($board) {
    }
}
