<?php

namespace Webthumbnail\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
* WebthumbnailServiceFactory
* @author El Hakym Khalid <khalid.elhakym@gmail.com>
*/

class WebthumbnailServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $services) {
        $config = $services->get('config');
        $service = new \Webthumbnail\Lib\Webthumbnail();
        if(isset($config['webthumbnail']['path'])) $service = $service->setPath($config['webthumbnail']['path']);  

        return $service;
    }

}
