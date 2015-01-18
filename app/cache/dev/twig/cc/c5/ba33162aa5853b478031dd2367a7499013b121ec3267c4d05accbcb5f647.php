<?php

/* MorenwareDutilsBundle:Default:search.html.twig */
class __TwigTemplate_ccc5ba33162aa5853b478031dd2367a7499013b121ec3267c4d05accbcb5f647 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("MorenwareDutilsBundle::base.html.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "MorenwareDutilsBundle::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "

<div class=\"searchTorrentsPage\" ng-controller=\"searchController\" ng-init=\"initTorrents(";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["torrentsInfo"]) ? $context["torrentsInfo"] : $this->getContext($context, "torrentsInfo")), "html", null, true);
        echo ")\">
   <div class=\"row\">
\t    <div class=\"col-lg-12\">
\t     <h1 class=\"page-header\">Buscar torrents</h1>
\t    </div>
\t</div>
\t
\t<div class=\"row search-form\">
\t\t <div class=\"input-group custom-search-form col-lg-12\">
         \t<input type=\"text\" class=\"form-control\" ng-model=\"query\" placeholder=\"Buscar...\">
            <span class=\"input-group-btn\">
              <button class=\"btn btn-default\" type=\"button\" ng-click=\"search()\">
                <i class=\"fa fa-search\"></i>
              </button>
              
";
        // line 24
        echo "              
            </span>
         </div>
\t</div>
\t
\t<div class=\"row search-results\" ng-show=\"searchFinished\">
\t    <div class=\"col-lg-12\">    
\t                <h4>Resultados para: '[[query]]'</h4>
\t                <h5>[[offset]]-[[currentOffset - 1]] de [[total]]</h5>
                     <div class=\"table-responsive\">
                        <table class=\"table table-striped\">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat=\"torrent in torrents\">
                                    <td ng-bind=\"offset+\$index\"></td>
                                    <td ng-bind=\"torrent.torrentName\"></td>
                                    <td class=\"col-lg-6\">
                                        <a ng-show=\"torrent.magnetLink\" href=\"[[torrent.magnetLink]]\" target=\"_blank\" class=\"col-lg-3 magnet\">Magnet</a>&nbsp;
                                        <a href=\"[[torrent.torrentFileLink]]\" class=\"download-torrent\" target=\"_blank\" class=\"col-lg-3\">Download</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
\t
\t\t</div>
\t\t
\t</div>\t
\t\t
";
    }

    public function getTemplateName()
    {
        return "MorenwareDutilsBundle:Default:search.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 24,  35 => 6,  31 => 4,  28 => 3,);
    }
}
