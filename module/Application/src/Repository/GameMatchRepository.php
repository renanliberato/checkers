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

    const FILE_PATH = './data/match_{id}.json';

    /**
     * @param string $id
     * @return \Application\Model\GameMatch
     * @throws Exception
     */
    public function get($id) {
        $file = $this->getFilePath($id);
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
        file_put_contents($this->getFilePath($match->getId()), json_encode($match));
    }

    private function getFilePath($id) {
        return str_replace('{id}', $id, self::FILE_PATH);
    }
}
