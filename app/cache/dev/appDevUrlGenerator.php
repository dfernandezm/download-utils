<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * appDevUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    private static $declaredRoutes = array(
        '_assetic_jquery' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'jquery',    'pos' => NULL,    '_format' => 'js',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/jquery.js',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_assetic_jquery_0' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'jquery',    'pos' => 0,    '_format' => 'js',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/jquery_jquery_1.js',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_assetic_bootstrap_js' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'bootstrap_js',    'pos' => NULL,    '_format' => 'js',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/bootstrap_js.js',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_assetic_bootstrap_js_0' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'bootstrap_js',    'pos' => 0,    '_format' => 'js',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/bootstrap_js_bootstrap.min_1.js',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_assetic_angular_js' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'angular_js',    'pos' => NULL,    '_format' => 'js',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/angular_js.js',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_assetic_angular_js_0' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'angular_js',    'pos' => 0,    '_format' => 'js',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/angular_js_angular.min_1.js',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_assetic_bootstrap_css' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'bootstrap_css',    'pos' => NULL,    '_format' => 'css',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/bootstrap_css.css',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_assetic_bootstrap_css_0' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'assetic.controller:render',    'name' => 'bootstrap_css',    'pos' => 0,    '_format' => 'css',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/assetic/bootstrap_css_bootstrap.min_1.css',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_wdt' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:toolbarAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    1 =>     array (      0 => 'text',      1 => '/_wdt',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_home' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:homeAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_search' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:searchAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/search',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_search_bar' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:searchBarAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/search_bar',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_purge' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:purgeAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/purge',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_info' => array (  0 =>   array (    0 => 'about',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:infoAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'about',    ),    1 =>     array (      0 => 'text',      1 => '/_profiler/info',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_import' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:importAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/import',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_export' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:exportAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '.txt',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler/export',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_phpinfo' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_profiler/phpinfo',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_search_results' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:searchResultsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/search/results',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.profiler:panelAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    1 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_router' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.router:panelAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/router',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_exception' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.exception:showAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/exception',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_profiler_exception_css' => array (  0 =>   array (    0 => 'token',  ),  1 =>   array (    '_controller' => 'web_profiler.controller.exception:cssAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/exception.css',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/_profiler',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_configurator_home' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_configurator/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_configurator_step' => array (  0 =>   array (    0 => 'index',  ),  1 =>   array (    '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'index',    ),    1 =>     array (      0 => 'text',      1 => '/_configurator/step',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_configurator_final' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/_configurator/final',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_base_homepage' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/base/home',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_v1_get_instance' => array (  0 =>   array (    0 => 'id',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::getInstanceAction',    '_format' => NULL,  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'json|xml|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'json|xml|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'id',    ),    2 =>     array (      0 => 'text',      1 => '/api/v1/instances',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'api_v1_post_instance' => array (  0 =>   array (    0 => 'instance',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::postInstanceAction',    '_format' => NULL,  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'json|xml|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'json|xml|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'instance',    ),    2 =>     array (      0 => 'text',      1 => '/api/v1/instances',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_welcome' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo_login' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::loginAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/demo/secured/login',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo_security_check' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::securityCheckAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/demo/secured/login_check',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo_logout' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::logoutAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/demo/secured/logout',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'acme_demo_secured_hello' => array (  0 =>   array (  ),  1 =>   array (    'name' => 'World',    '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/demo/secured/hello',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo_secured_hello' => array (  0 =>   array (    0 => 'name',  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'name',    ),    1 =>     array (      0 => 'text',      1 => '/demo/secured/hello',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo_secured_hello_admin' => array (  0 =>   array (    0 => 'name',  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloadminAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'name',    ),    1 =>     array (      0 => 'text',      1 => '/demo/secured/hello/admin',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/demo/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo_hello' => array (  0 =>   array (    0 => 'name',  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::helloAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'name',    ),    1 =>     array (      0 => 'text',      1 => '/demo/hello',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_demo_contact' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::contactAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/demo/contact',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_default_index' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/home',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_default_feeds' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::feedsAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/feeds',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_default_search' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::searchAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/search',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_instance_getinstance' => array (  0 =>   array (    0 => 'id',  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::getInstanceAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'id',    ),    1 =>     array (      0 => 'text',      1 => '/api/instances',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_instance_postinstance' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::postInstanceAction',  ),  2 =>   array (    '_method' => 'POST',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/instances',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_notify_postnotification' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\NotifyController::postNotificationAction',  ),  2 =>   array (    '_method' => 'POST',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/notify',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_notify_postcheckfeeds' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\NotifyController::postCheckFeeds',  ),  2 =>   array (    '_method' => 'POST',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/notify/checkFeeds',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_searchtorrents_searchquery' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::searchQueryAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/search',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_searchtorrents_downloadtorrentfileondemand' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::downloadTorrentFileOnDemandAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/search/torrent/get',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_searchtorrents_addtorrent' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::addTorrentAction',  ),  2 =>   array (    '_method' => 'POST',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/search/torrent/addfile',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_searchtorrents_downloadtorrent' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::downloadTorrentAction',  ),  2 =>   array (    '_method' => 'POST',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/torrent/download',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_getfeed' => array (  0 =>   array (    0 => 'id',  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::getFeedAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'id',    ),    1 =>     array (      0 => 'text',      1 => '/api/feeds',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_createfeedpost' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::createFeedPostAction',  ),  2 =>   array (    '_method' => 'POST',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/feeds',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_updatefeed' => array (  0 =>   array (    0 => 'id',  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::updateFeedAction',  ),  2 =>   array (    '_method' => 'PUT',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'id',    ),    1 =>     array (      0 => 'text',      1 => '/api/feeds',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_deletefeed' => array (  0 =>   array (    0 => 'id',  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::deleteFeedAction',  ),  2 =>   array (    '_method' => 'DELETE',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'id',    ),    1 =>     array (      0 => 'text',      1 => '/api/feeds',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_listfeeds' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::listFeedsAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/feeds',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_checkfeeds' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::checkFeedsAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/feedscheck',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_checktorrents' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::checkTorrentsAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/torrents/check',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'morenware_dutils_torrentfeed_checktorrentscontinuously' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::checkTorrentsContinuouslyAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/torrents/checkdaemon',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
    );

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context, LoggerInterface $logger = null)
    {
        $this->context = $context;
        $this->logger = $logger;
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (!isset(self::$declaredRoutes[$name])) {
            throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens, $hostTokens, $requiredSchemes) = self::$declaredRoutes[$name];

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);
    }
}
