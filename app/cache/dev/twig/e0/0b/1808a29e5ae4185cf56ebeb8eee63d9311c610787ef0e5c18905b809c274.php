<?php

/* MorenwareDutilsBundle::base.html.twig */
class __TwigTemplate_e00b1808a29e5ae4185cf56ebeb8eee63d9311c610787ef0e5c18905b809c274 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html ng-app=\"dutilsApp\">
<head>   
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">

    <title>Download Utils Manager</title>
    
      \t";
        // line 12
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 26
        echo "

\t <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
        <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>
    <![endif]-->

</head>
    <body>
       <div id=\"wrapper\">

\t\t";
        // line 39
        $this->env->loadTemplate("MorenwareDutilsBundle::nav.html.twig")->display($context);
        // line 40
        echo "\t\t
        <div id=\"page-wrapper\">
      \t\t  ";
        // line 42
        $this->displayBlock('body', $context, $blocks);
        // line 43
        echo "        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    ";
        // line 48
        $this->displayBlock('javascripts', $context, $blocks);
        // line 66
        echo "
</html>";
    }

    // line 12
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 13
        echo "      \t
          <link href=\"client/css/bootstrap.min.css\" rel=\"stylesheet\" />
          <link href=\"client/css/metis-menu.css\" rel=\"stylesheet\" />
          <link href=\"client/css/sb-admin-2.css\" rel=\"stylesheet\" />
          <link href=\"client/css/main.css\" rel=\"stylesheet\" />
          <link href=\"client/font-awesome-4.1.0/css/font-awesome.min.css\" rel=\"stylesheet\" />

";
        // line 24
        echo "            
        ";
    }

    // line 42
    public function block_body($context, array $blocks = array())
    {
    }

    // line 48
    public function block_javascripts($context, array $blocks = array())
    {
        // line 49
        echo "       
";
        // line 54
        echo "\t\t
";
        // line 56
        echo "\t\t
\t\t
\t    <script type=\"text/javascript\" src=\"client/js/lib/jquery.js\"></script>
\t    <script type=\"text/javascript\" src=\"client/js/lib/bootstrap.min.js\"></script>
\t    <script type=\"text/javascript\" src=\"client/js/plugins/metisMenu/metisMenu.min.js\"></script>
\t    <script type=\"text/javascript\" src=\"client/js/sb-admin-2.js\"></script>
\t\t<script type=\"text/javascript\" src=\"client/js/app/init.js\"></script>
\t\t

    ";
    }

    public function getTemplateName()
    {
        return "MorenwareDutilsBundle::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 56,  102 => 54,  99 => 49,  96 => 48,  91 => 42,  86 => 24,  77 => 13,  74 => 12,  69 => 66,  67 => 48,  60 => 43,  58 => 42,  54 => 40,  52 => 39,  37 => 26,  22 => 1,  53 => 24,  35 => 12,  31 => 4,  28 => 3,);
    }
}
