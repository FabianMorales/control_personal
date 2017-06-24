<?php

class myDocumento{
    var $archivosJs;
    var $archivosCss;
    var $tituloWeb;
    
    public function __construct(){
        $this->archivosJs = [];
        $this->archivosCss = [];
    }
    
    public function getJs(){
        return $this->archivosJs;
    }
    
    public function getCss(){
        return $this->archivosCss;
    }
    
    public function establecerTitulo($titulo){
        $this->tituloWeb = $titulo;
    }

    public function addScript($url){
        if (!in_array($url, $this->archivosJs)){
            $this->archivosJs[] = $url;
        }
    }

    public function addScripts($array_url){        
        foreach ($array_url as $url){
            $this->addScript($url);
        }
    }

    public function addEstilo($url){
        if (!in_array($url, $this->archivosJs)){
            $this->archivosCss[] = $url;
        }
    }

    public function addEstilos($array_url){
        foreach ($array_url as $url){
            $this->addEstilo($url);
        }
    }
}