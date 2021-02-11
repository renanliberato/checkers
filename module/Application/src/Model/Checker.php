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

    /**
     * 'b' or 'w'
     * @var string
     */
    public $team;
    
    /**
     * 'black' or 'white'
     * @var string
     */
    public $color;
    
    /**
     * @var string
     */
    public $id;
    
    /**
     * @var int
     */
    public $position;
    
    public function __construct($color, $id, $position) {
        $this->id = $id == null ? (\Ramsey\Uuid\Uuid::uuid4())->toString() : $id;
        $this->color = $color;
        $this->team = $color[0];
        $this->position = $position;
    }
}
