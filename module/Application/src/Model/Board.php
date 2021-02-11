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
    public $spaces;
    
    public function __construct()
    {
        /*$this->spaces = [
            1 => [
                'j' => new Space('black', new Checker('white')),
                'i' => new Space('white'),
                'h' => new Space('black', new Checker('white')),
                'g' => new Space('white'),
                'f' => new Space('black', new Checker('white')),
                'e' => new Space('white'),
                'd' => new Space('black', new Checker('white')),
                'c' => new Space('white'),
                'b' => new Space('black', new Checker('white')),
                'a' => new Space('white'),
            ],
            2 => [
                'j' => new Space('white'),
                'i' => new Space('black', new Checker('white')),
                'h' => new Space('white'),
                'g' => new Space('black', new Checker('white')),
                'f' => new Space('white'),
                'e' => new Space('black', new Checker('white')),
                'd' => new Space('white'),
                'c' => new Space('black', new Checker('white')),
                'b' => new Space('white'),
                'a' => new Space('black', new Checker('white')),
            ],
            3 => [
                'j' => new Space('black', new Checker('white')),
                'i' => new Space('white'),
                'h' => new Space('black', new Checker('white')),
                'g' => new Space('white'),
                'f' => new Space('black', new Checker('white')),
                'e' => new Space('white'),
                'd' => new Space('black', new Checker('white')),
                'c' => new Space('white'),
                'b' => new Space('black', new Checker('white')),
                'a' => new Space('white'),
            ],
            4 => [
                'j' => new Space('white'),
                'i' => new Space('black', new Checker('white')),
                'h' => new Space('white'),
                'g' => new Space('black', new Checker('white')),
                'f' => new Space('white'),
                'e' => new Space('black', new Checker('white')),
                'd' => new Space('white'),
                'c' => new Space('black', new Checker('white')),
                'b' => new Space('white'),
                'a' => new Space('black', new Checker('white')),
            ],
            5 => [
                'j' => new Space('black'),
                'i' => new Space('white'),
                'h' => new Space('black'),
                'g' => new Space('white'),
                'f' => new Space('black'),
                'e' => new Space('white'),
                'd' => new Space('black'),
                'c' => new Space('white'),
                'b' => new Space('black'),
                'a' => new Space('white'),
            ],
            6 => [
                'j' => new Space('white'),
                'i' => new Space('black'),
                'h' => new Space('white'),
                'g' => new Space('black'),
                'f' => new Space('white'),
                'e' => new Space('black'),
                'd' => new Space('white'),
                'c' => new Space('black'),
                'b' => new Space('white'),
                'a' => new Space('black'),
            ],
            7 => [
                'j' => new Space('black', new Checker('black')),
                'i' => new Space('white'),
                'h' => new Space('black', new Checker('black')),
                'g' => new Space('white'),
                'f' => new Space('black', new Checker('black')),
                'e' => new Space('white'),
                'd' => new Space('black', new Checker('black')),
                'c' => new Space('white'),
                'b' => new Space('black', new Checker('black')),
                'a' => new Space('white'),
            ],
            8 => [
                'j' => new Space('white'),
                'i' => new Space('black', new Checker('black')),
                'h' => new Space('white'),
                'g' => new Space('black', new Checker('black')),
                'f' => new Space('white'),
                'e' => new Space('black', new Checker('black')),
                'd' => new Space('white'),
                'c' => new Space('black', new Checker('black')),
                'b' => new Space('white'),
                'a' => new Space('black', new Checker('black')),
            ],
            9 => [
                'j' => new Space('black', new Checker('black')),
                'i' => new Space('white'),
                'h' => new Space('black', new Checker('black')),
                'g' => new Space('white'),
                'f' => new Space('black', new Checker('black')),
                'e' => new Space('white'),
                'd' => new Space('black', new Checker('black')),
                'c' => new Space('white'),
                'b' => new Space('black', new Checker('black')),
                'a' => new Space('white'),
            ],
            10 => [
                'j' => new Space('white'),
                'i' => new Space('black', new Checker('black')),
                'h' => new Space('white'),
                'g' => new Space('black', new Checker('black')),
                'f' => new Space('white'),
                'e' => new Space('black', new Checker('black')),
                'd' => new Space('white'),
                'c' => new Space('black', new Checker('black')),
                'b' => new Space('white'),
                'a' => new Space('black', new Checker('black')),
            ],
        ];*/
    }
}
