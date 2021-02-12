<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Repository;

/**
 * Description of GameMatchRepositoryFactory
 *
 * @author renan
 */
class GameMatchRepositoryFactory {
    
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, ?array $options = NULL) {
        return new GameMatchRepository();
    }
}
