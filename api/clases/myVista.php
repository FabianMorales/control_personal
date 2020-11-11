<?php

use Dompdf\Dompdf;

class myVista {
    private static $twig;
    
    public static function boot(){
        Twig_Autoloader::register();
                
        $dirTemplates[] = dirname(__DIR__).DS."vistas".DS;
        
        $loaderTwig = new Twig_Loader_Filesystem($dirTemplates);
        myVista::$twig = new Twig_Environment($loaderTwig, array("cache" => false));
        
        $assetFn = new Twig_SimpleFunction("asset", array(myVista::class, "asset"));        
        myVista::$twig->addFunction($assetFn);
        
        $urlFn = new Twig_SimpleFunction("url", array(myVista::class, "url"));        
        myVista::$twig->addFunction($urlFn);
    }
    
    public static function render($vista, $vars = []){
        $doc = myApp::getDocumento();
        $vars["js_doc"] = $doc->getJs();
        $vars["css_doc"] = $doc->getCss();
        $vista = str_replace(".", "/", $vista).".twig";
        return myVista::$twig->render($vista, $vars);
    }
	
    public static function renderPdf($vista, $vars){
        $html = myVista::render($vista, $vars);
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream();
    }
    
    public static function asset($url){
        return $ruta = BASE_DIR."/".$url;
    }
    
    public static function url($url){
        return myApp::getUrlBase().$url;
    }
}
