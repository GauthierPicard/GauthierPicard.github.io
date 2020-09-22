<?php

/* Author : Yann KRUPA, www.emse.fr/~krupa */
/* I've tried other Bib2Html scripts that I did not like, so I made one. 
   I know my script is incomplete and doesn't handle all the parameter it should
   Nevertheless, it is sufficient to display your own bibliography
*/

/* To format the output, add corresponding classes in your CSS for:
bibyear
bibauthor
bibtitle
bibconf
*/


//The .bib file name can be defined outside this file, just before the "include" to allow multiple bibfiles ex:
// $bibfile="foo.bib";
// include("Bib2Html.php");
// $bibfile="bar.bib";
// include("Bib2Html.php");
// in this case, the line just below should be commented.
$bibfile="book.bib";
//The name parameter for the bibtex getter:
$param_name="bibtexref";



class Bib {
  private $ref;
  private $authors;
  private $title;
  private $in=""; //published in LNCS?
  private $year;
  private $url;
  private $type; 
  
  public function __construct($entry){
    $source= array("\\'e","\\'E","\\`e","\\`E","\\`a","\\`A");
    $target= array("&eacute;","&Eacute;","&egrave;","&Egrave","&agrave;","&Agrave;");
    $entry = str_replace($source,$target,$entry);
    $this->parse($entry);
  }
  
  public function getRef(){
    return $this->ref;
  }
  public function getAuthors(){
    return $this->authors;
  }
  public function getTitle(){
    return $this->title;
  }
  public function getIn(){
    return $this->in;
  }
  public function getYear(){
    return $this->year; 
  }
  public function getURL(){
    return $this->url; 
  }
  
  public function parse($entry){
  //this will parse a bib entry 
  
    preg_match("/@(.*)\{(.*),/i", $entry, $matches);
    $this->type=strtolower($matches[1]); //type : book, proceedings, inproceedings
    $this->ref=$matches[2];//bibref
    
    if(preg_match("/title\s*=\s*\{\{(.*)\}\}\s*/i", $entry, $matches)){
    }else preg_match("/title\s*=\s*\{(.*)\}\s*/i", $entry, $matches);
    $this->title=$matches[1];//titre
    
    if(preg_match("/author\s*=\s*\{(.*)\}\s*/i", $entry, $matches)){
    $this->authors=$matches[1];//auteurs
    }
    
    if(preg_match("/year\s*=\s*\{(.*)\}\s*/i", $entry, $matches)){
      $this->year=$matches[1];//année
    }
    if(preg_match("/url\s*=\s*\{(.*)\}\s*/i", $entry, $matches)){
      $this->url=$matches[1];//url
    }//else echo "no url";
   
    
    
    //Suivant le type, on applique une mise en forme spéciale, et le "in" change:
    // article in journal...
    // inproceedings in booktitle...
    if($this->type == "article"){
       $in = "journal";
       if(preg_match("/$in\s*=\s*\{(.*)\}\s*/i", $entry, $matches)){
        $this->in=$matches[1];  
       }
    }
    if($this->type == "phdthesis"){
        $this->in = "Phd Thesis";
     }
    if($this->type == "mastersthesis"){
        $this->in = "Master's Thesis";
    }
    
    if($this->type == "book"){
        $this->in = "Book";
    }
    if($this->type == "techreport"){
        $in="institution";
        if( preg_match("/$in\s*=\s*\{(.*)\}\s*/i", $entry, $matches)){
          $this->in = "Tech Report, ".$matches[1];
        }
    }
    
    if($this->type == "inproceedings"){
        $in="booktitle";
        if( preg_match("/$in\s*=\s*\{(.*)\}\s*/i", $entry, $matches)){
          $this->in = $matches[1];
        }
    }
    
  }
  
  function __toString(){
    return "\n<span class='bibyear'>".$this->year."</span>: <span class='bibauthor'>".$this->authors."</span>, <span class='bibtitle'>".$this->title.".</span> <span class='bibconf'>".$this->in."</span>. " ;
  }
  
  
  
}  

class BibParser{
  private $data;
  
  function __construct($file){
     $this->data = @file_get_contents($file)
                    or die('Erreur de lecture');
  }
  
  
  function getBibTex($ref){
    //echo $this->data;
    //echo $ref;
    preg_match("/@.*\{$ref,([^@]*)/i", $this->data, $matches) or die("ref error");
    return $matches[0];
  }

  function getBib($ref){
    return new Bib($this->getBibTex($ref));
  }
  
  //retourne un tableau de bib
  function parse(){
    preg_match_all("/@.*\{(.*),/i", $this->data, $matches);
    //print_r($matches);
    foreach($matches[1] as $item){
      $arr[] = $this->getBib($item); 
    }
    
    return $arr;
  }
  
}


/*sample

@article{SABA05,
title={Review on Computational Trust and Reputation Models},
author={Sabater, J. and Sierra, C.},
journal={Artificial Intelligence Review},
year={2005}
}
*/

$test = new BibParser($bibfile);

//lorsque un bibtex est demandé :
if(!empty($_GET["$param_name"])){
  header('Content-type: text/plain');
  echo $test -> getBibTex($_GET["$param_name"]);
  exit;
}


$array = $test->parse();
echo "<ul>";
foreach($array as $item ){
  echo "<li>".$item ;//toString
  if($item->getURL()!="") echo " <a href='".$item->getURL()."'>[Pdf]</a>";
  echo " <a href='$bibrep/Bib2Html.php?$param_name=".$item->getRef()."'>[Bib]</a></li>";
}

echo "</ul>";


?>
