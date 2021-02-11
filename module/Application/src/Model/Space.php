<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of Space
 *
 * @author renan
 */
class Space {

    public $x;
    public $y;
    public $checker;
    public $color;

    public function __construct($color, $checker = null) {
        $this->color = $color;
        $this->checker = $checker;
    }

}
