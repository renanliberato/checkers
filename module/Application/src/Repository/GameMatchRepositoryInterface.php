<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Repository;

/**
 *
 * @author renan
 */
interface GameMatchRepositoryInterface {
    /**
     * @param string $id
     * @return \Application\Model\GameMatch
     * @throws Exception
     */
    public function get($id);
    
    /**
     * @param \Application\Model\GameMatch $match
     */
    public function save(\Application\Model\GameMatch $match);
}
