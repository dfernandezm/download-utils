<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/assetic')) {
            if (0 === strpos($pathinfo, '/assetic/jquery')) {
                // _assetic_jquery
                if ($pathinfo === '/assetic/jquery.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'jquery',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_jquery',);
                }

                // _assetic_jquery_0
                if ($pathinfo === '/assetic/jquery_jquery_1.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'jquery',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_jquery_0',);
                }

            }

            if (0 === strpos($pathinfo, '/assetic/bootstrap_js')) {
                // _assetic_bootstrap_js
                if ($pathinfo === '/assetic/bootstrap_js.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'bootstrap_js',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_bootstrap_js',);
                }

                // _assetic_bootstrap_js_0
                if ($pathinfo === '/assetic/bootstrap_js_bootstrap.min_1.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'bootstrap_js',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_bootstrap_js_0',);
                }

            }

            if (0 === strpos($pathinfo, '/assetic/angular_js')) {
                // _assetic_angular_js
                if ($pathinfo === '/assetic/angular_js.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_js',);
                }

                // _assetic_angular_js_0
                if ($pathinfo === '/assetic/angular_js_angular.min_1.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_js_0',);
                }

            }

            if (0 === strpos($pathinfo, '/assetic/bootstrap_css')) {
                // _assetic_bootstrap_css
                if ($pathinfo === '/assetic/bootstrap_css.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'bootstrap_css',  'pos' => NULL,  '_format' => 'css',  '_route' => '_assetic_bootstrap_css',);
                }

                // _assetic_bootstrap_css_0
                if ($pathinfo === '/assetic/bootstrap_css_bootstrap.min_1.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'bootstrap_css',  'pos' => 0,  '_format' => 'css',  '_route' => '_assetic_bootstrap_css_0',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        // morenware_dutils_base_homepage
        if ($pathinfo === '/base/home') {
            return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::indexAction',  '_route' => 'morenware_dutils_base_homepage',);
        }

        if (0 === strpos($pathinfo, '/api/v1/instances')) {
            // api_v1_get_instance
            if (preg_match('#^/api/v1/instances/(?P<id>[^/\\.]++)(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_api_v1_get_instance;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_v1_get_instance')), array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::getInstanceAction',  '_format' => NULL,));
            }
            not_api_v1_get_instance:

            // api_v1_post_instance
            if (preg_match('#^/api/v1/instances/(?P<instance>[^/\\.]++)(?:\\.(?P<_format>json|xml|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_api_v1_post_instance;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'api_v1_post_instance')), array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::postInstanceAction',  '_format' => NULL,));
            }
            not_api_v1_post_instance:

        }

        // _welcome
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_welcome');
            }

            return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::indexAction',  '_route' => '_welcome',);
        }

        if (0 === strpos($pathinfo, '/demo')) {
            if (0 === strpos($pathinfo, '/demo/secured')) {
                if (0 === strpos($pathinfo, '/demo/secured/log')) {
                    if (0 === strpos($pathinfo, '/demo/secured/login')) {
                        // _demo_login
                        if ($pathinfo === '/demo/secured/login') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::loginAction',  '_route' => '_demo_login',);
                        }

                        // _demo_security_check
                        if ($pathinfo === '/demo/secured/login_check') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::securityCheckAction',  '_route' => '_demo_security_check',);
                        }

                    }

                    // _demo_logout
                    if ($pathinfo === '/demo/secured/logout') {
                        return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::logoutAction',  '_route' => '_demo_logout',);
                    }

                }

                if (0 === strpos($pathinfo, '/demo/secured/hello')) {
                    // acme_demo_secured_hello
                    if ($pathinfo === '/demo/secured/hello') {
                        return array (  'name' => 'World',  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',  '_route' => 'acme_demo_secured_hello',);
                    }

                    // _demo_secured_hello
                    if (preg_match('#^/demo/secured/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',));
                    }

                    // _demo_secured_hello_admin
                    if (0 === strpos($pathinfo, '/demo/secured/hello/admin') && preg_match('#^/demo/secured/hello/admin/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello_admin')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloadminAction',));
                    }

                }

            }

            // _demo
            if (rtrim($pathinfo, '/') === '/demo') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_demo');
                }

                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::indexAction',  '_route' => '_demo',);
            }

            // _demo_hello
            if (0 === strpos($pathinfo, '/demo/hello') && preg_match('#^/demo/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::helloAction',));
            }

            // _demo_contact
            if ($pathinfo === '/demo/contact') {
                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::contactAction',  '_route' => '_demo_contact',);
            }

        }

        // morenware_dutils_default_index
        if ($pathinfo === '/home') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_morenware_dutils_default_index;
            }

            return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::indexAction',  '_route' => 'morenware_dutils_default_index',);
        }
        not_morenware_dutils_default_index:

        // morenware_dutils_default_feeds
        if ($pathinfo === '/feeds') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_morenware_dutils_default_feeds;
            }

            return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::feedsAction',  '_route' => 'morenware_dutils_default_feeds',);
        }
        not_morenware_dutils_default_feeds:

        // morenware_dutils_default_search
        if ($pathinfo === '/search') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_morenware_dutils_default_search;
            }

            return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\DefaultController::searchAction',  '_route' => 'morenware_dutils_default_search',);
        }
        not_morenware_dutils_default_search:

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/instances')) {
                // morenware_dutils_instance_getinstance
                if (preg_match('#^/api/instances/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_morenware_dutils_instance_getinstance;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'morenware_dutils_instance_getinstance')), array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::getInstanceAction',));
                }
                not_morenware_dutils_instance_getinstance:

                // morenware_dutils_instance_postinstance
                if ($pathinfo === '/api/instances') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_morenware_dutils_instance_postinstance;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\InstanceController::postInstanceAction',  '_route' => 'morenware_dutils_instance_postinstance',);
                }
                not_morenware_dutils_instance_postinstance:

            }

            if (0 === strpos($pathinfo, '/api/notify')) {
                // morenware_dutils_notify_postnotification
                if ($pathinfo === '/api/notify') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_morenware_dutils_notify_postnotification;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\NotifyController::postNotificationAction',  '_route' => 'morenware_dutils_notify_postnotification',);
                }
                not_morenware_dutils_notify_postnotification:

                // morenware_dutils_notify_postcheckfeeds
                if ($pathinfo === '/api/notify/checkFeeds') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_morenware_dutils_notify_postcheckfeeds;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\NotifyController::postCheckFeeds',  '_route' => 'morenware_dutils_notify_postcheckfeeds',);
                }
                not_morenware_dutils_notify_postcheckfeeds:

            }

            if (0 === strpos($pathinfo, '/api/search')) {
                // morenware_dutils_searchtorrents_searchquery
                if ($pathinfo === '/api/search') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_morenware_dutils_searchtorrents_searchquery;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::searchQueryAction',  '_route' => 'morenware_dutils_searchtorrents_searchquery',);
                }
                not_morenware_dutils_searchtorrents_searchquery:

                if (0 === strpos($pathinfo, '/api/search/torrent')) {
                    // morenware_dutils_searchtorrents_downloadtorrentfileondemand
                    if ($pathinfo === '/api/search/torrent/get') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_morenware_dutils_searchtorrents_downloadtorrentfileondemand;
                        }

                        return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::downloadTorrentFileOnDemandAction',  '_route' => 'morenware_dutils_searchtorrents_downloadtorrentfileondemand',);
                    }
                    not_morenware_dutils_searchtorrents_downloadtorrentfileondemand:

                    // morenware_dutils_searchtorrents_addtorrent
                    if ($pathinfo === '/api/search/torrent/addfile') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_morenware_dutils_searchtorrents_addtorrent;
                        }

                        return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::addTorrentAction',  '_route' => 'morenware_dutils_searchtorrents_addtorrent',);
                    }
                    not_morenware_dutils_searchtorrents_addtorrent:

                }

            }

            // morenware_dutils_searchtorrents_downloadtorrent
            if ($pathinfo === '/api/torrent/download') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_morenware_dutils_searchtorrents_downloadtorrent;
                }

                return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\SearchTorrentsController::downloadTorrentAction',  '_route' => 'morenware_dutils_searchtorrents_downloadtorrent',);
            }
            not_morenware_dutils_searchtorrents_downloadtorrent:

            if (0 === strpos($pathinfo, '/api/feeds')) {
                // morenware_dutils_torrentfeed_getfeed
                if (preg_match('#^/api/feeds/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_morenware_dutils_torrentfeed_getfeed;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'morenware_dutils_torrentfeed_getfeed')), array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::getFeedAction',));
                }
                not_morenware_dutils_torrentfeed_getfeed:

                // morenware_dutils_torrentfeed_createfeedpost
                if ($pathinfo === '/api/feeds') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_morenware_dutils_torrentfeed_createfeedpost;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::createFeedPostAction',  '_route' => 'morenware_dutils_torrentfeed_createfeedpost',);
                }
                not_morenware_dutils_torrentfeed_createfeedpost:

                // morenware_dutils_torrentfeed_updatefeed
                if (preg_match('#^/api/feeds/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_morenware_dutils_torrentfeed_updatefeed;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'morenware_dutils_torrentfeed_updatefeed')), array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::updateFeedAction',));
                }
                not_morenware_dutils_torrentfeed_updatefeed:

                // morenware_dutils_torrentfeed_deletefeed
                if (preg_match('#^/api/feeds/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_morenware_dutils_torrentfeed_deletefeed;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'morenware_dutils_torrentfeed_deletefeed')), array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::deleteFeedAction',));
                }
                not_morenware_dutils_torrentfeed_deletefeed:

                // morenware_dutils_torrentfeed_listfeeds
                if ($pathinfo === '/api/feeds') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_morenware_dutils_torrentfeed_listfeeds;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::listFeedsAction',  '_route' => 'morenware_dutils_torrentfeed_listfeeds',);
                }
                not_morenware_dutils_torrentfeed_listfeeds:

                // morenware_dutils_torrentfeed_checkfeeds
                if ($pathinfo === '/api/feedscheck') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_morenware_dutils_torrentfeed_checkfeeds;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::checkFeedsAction',  '_route' => 'morenware_dutils_torrentfeed_checkfeeds',);
                }
                not_morenware_dutils_torrentfeed_checkfeeds:

            }

            if (0 === strpos($pathinfo, '/api/torrents/check')) {
                // morenware_dutils_torrentfeed_checktorrents
                if ($pathinfo === '/api/torrents/check') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_morenware_dutils_torrentfeed_checktorrents;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::checkTorrentsAction',  '_route' => 'morenware_dutils_torrentfeed_checktorrents',);
                }
                not_morenware_dutils_torrentfeed_checktorrents:

                // morenware_dutils_torrentfeed_checktorrentscontinuously
                if ($pathinfo === '/api/torrents/checkdaemon') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_morenware_dutils_torrentfeed_checktorrentscontinuously;
                    }

                    return array (  '_controller' => 'Morenware\\DutilsBundle\\Controller\\TorrentFeedController::checkTorrentsContinuouslyAction',  '_route' => 'morenware_dutils_torrentfeed_checktorrentscontinuously',);
                }
                not_morenware_dutils_torrentfeed_checktorrentscontinuously:

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
