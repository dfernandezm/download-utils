<?php

namespace Morenware\DutilsBundle\Controller;

/**
 * This code has been auto-generated by the JMSDiExtraBundle.
 *
 * Manual changes to it will be lost.
 */
class TorrentFeedController__JMSInjector
{
    public static function inject($container) {
        $instance = new \Morenware\DutilsBundle\Controller\TorrentFeedController();
        $refProperty = new \ReflectionProperty('Morenware\\DutilsBundle\\Controller\\TorrentFeedController', 'serializer');
        $refProperty->setAccessible(true);
        $refProperty->setValue($instance, $container->get('jms_serializer', 1));
        $refProperty = new \ReflectionProperty('Morenware\\DutilsBundle\\Controller\\TorrentFeedController', 'torrentFeedService');
        $refProperty->setAccessible(true);
        $refProperty->setValue($instance, $container->get('torrentfeed.service', 1));
        $refProperty = new \ReflectionProperty('Morenware\\DutilsBundle\\Controller\\TorrentFeedController', 'logger');
        $refProperty->setAccessible(true);
        $refProperty->setValue($instance, $container->get('logger', 1));
        $instance->transmissionService = $container->get('transmission.service', 1);
        $instance->processManager = $container->get('processmanager.service', 1);
        $instance->torrentService = $container->get('torrent.service', 1);
        return $instance;
    }
}
