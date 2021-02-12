<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

/**
 * Description of IndexControllerFactory
 *
 * @author renan
 */
class IndexControllerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface {
    
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, ?array $options = NULL) {
        return new IndexController($container->get(\Application\Repository\GameMatchRepositoryInterface::class));
    }

}
