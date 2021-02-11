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
    public $row;
    public $column;
    public $canMoveTo;
    
    public function __construct($color, $team, $id, $rowKey, $columnKey) {
        $this->id = $id == null ? (\Ramsey\Uuid\Uuid::uuid4())->toString() : $id;
        $this->color = $color;
        $this->team = $team;
        $this->row = $rowKey;
        $this->column = $columnKey;
    }

    private $columns = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
    
    public function updatePossibleMovements($board) {
        $this->canMoveTo = $this->getPossibleMovements($board);
    }
    
    private function getPossibleMovements($board) {
        if ($this->team == 1) {
            if ($this->row == 10) {
                return [];
            }
            
            $curColumnIndex = array_search($this->column, $this->columns);
            $moveLeft = null;
            $moveRight = null;
            
            if ($curColumnIndex > 0 && $board->spaces[$this->row + 1][$this->columns[$curColumnIndex - 1]]->checker == null) {
                $moveLeft = [ 'row' => $this->row + 1, 'column' => $this->columns[$curColumnIndex - 1]];
            }
            
            if ($curColumnIndex < 9 && $board->spaces[$this->row + 1][$this->columns[$curColumnIndex + 1]]->checker == null) {
                $moveRight = [ 'row' => $this->row + 1, 'column' => $this->columns[$curColumnIndex + 1]];
            }
            
            return array_values(array_filter([$moveLeft, $moveRight], function($move) {
                return $move != null;
            }));
        }
    }
}
