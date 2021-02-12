<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Repository;

/**
 * Description of MatchRepository
 *
 * @author renan
 */
class GameMatchRepository implements GameMatchRepositoryInterface {
    /**
     * @param string $id
     * @return \Application\Model\GameMatch
     * @throws Exception
     */
    public function get($id) {
        $file = './data/match_' . $id . '.json';
        if (!file_exists($file)) {
            throw new Exception("Match not found");
        }

        $data = json_decode(file_get_contents($file), true);
        $data['id'] = $id;
        
        return \Application\Model\GameMatch::fromData($data);
    }
    
    /**
     * @param \Application\Model\GameMatch $match
     */
    public function save(\Application\Model\GameMatch $match) {
        file_put_contents('./data/match_' . $match->getId() . '.json', json_encode($match));
    }
}
