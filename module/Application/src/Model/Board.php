<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of Board
 *
 * @author renan
 */
class Board {
    public $checkers;
    public $fen;
    public $possibleMoves;
    
    public function __construct()
    {
        
    }
}
