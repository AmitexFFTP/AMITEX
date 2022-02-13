<?php
require_once('Cfile.php'); $file = new Cfile();
// print $file->getFileExtension($_GET["file"]);
if( empty($_GET["file"]) ) {
    print "<p>Il faut indiquer un fichier.</p>";
} else{
    $fichier=strip_tags($_GET["file"]);
        // si on ne precise pas de classe dans URL on prend par defaut :
        $chemin=$g_config->filedir['std'];

        if(isset($_GET["class"])){
                $class=strip_tags($_GET["class"]);
                if( strcasecmp($class,'dlamitex')==0 ){
                        require_once('dlamitex.php'); $tool = new Cnews();
                        $chemin=$tool->_dir['img'];
                } elseif( strcasecmp($class,'news')==0 ){
                        //necessaire pour les vieilles news
                        require_once('Cnews.php'); $tool = new Cnews();
                        $chemin=$tool->_dir['fic'];
                } elseif( strcasecmp($class,'ast')==0 ){
                        require_once('Cast.php'); $tool = new Cast();
                        $chemin=$tool->fileDir;
                } elseif( strcasecmp($class,'astimg')==0 ){
                        require_once('Cast.php'); $tool = new Cast();
                        $chemin=$tool->imgDir;
                } elseif( strcasecmp($class,'seminar')==0 ){
                        //necessaire pour les vieux seminaires
                        require_once('Cseminar.php'); $tool = new Cseminar();
                        $chemin=$tool->_dir['fic'];
                } elseif( strcasecmp($class,'page')==0 ){
                        require_once('Cedit.php'); $tool = new Cedit('page');
                        $chemin=$tool->edit_dir;
                } elseif( strcasecmp($class,'pisp')==0 ){
                        require_once('Cpisp.php'); $tool = new Cpisp();
                        $chemin=$tool->_dir['fic'];
                } elseif( strcasecmp($class,'cours')==0 ){
                        require_once('Ccours.php'); $tool = new Ccours();
                        $chemin=$tool->_dir;
                } elseif( strcasecmp($class,'base')==0 ){
                        $chemin=$g_config->filedir['base'];
                } elseif( strcasecmp($class,'pere')==0 ){
                        $chemin=$g_config->filedir['pere'];
                }
        }
        $file->sendFileToBrowser($chemin."/".$fichier);
}
?>
                                                                                                                                                        47,1          Bas


