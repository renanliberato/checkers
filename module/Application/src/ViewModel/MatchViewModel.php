<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\ViewModel;

/**
 * Description of MatchViewModel
 *
 * @author renan
 */
class MatchViewModel extends \Laminas\View\Model\ViewModel {
    
    /**
     * @param \Application\Model\GameMatch $match
     */
    public function __construct(\Application\Model\GameMatch $match) {
        parent::__construct([
            'turn' => $match->getTurn(),
            'match' => $match,
            'movements' => $match->getMovements()
        ]);
    }
}
