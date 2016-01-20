<?php
class adaptativeImage {

	public function __construct () {
		return true;
	}

	public function getAdaptativeImage() {
        
        global $thisSite;

    	if($this->adaptativeVigs=="") { $this->adaptativeVigs = $thisSite->defaultAdaptativeVigs; }
		
        $vignettes="";
        if(is_array($this->adaptativeVigs)) {
            foreach($this->adaptativeVigs as $limitWidth=>$indiceVignette){
                $vignettes[$indiceVignette]=get_vignette($this->image,$indiceVignette);
            }
        }
        
      // echoa($vignettes);
        
		$return="<img ";
		if($this->legende!="") { $return.="alt=\"" . $this->legende ."\" "; }
		if($this->moreElements!="") { $return.=" " . $this->moreElements ." "; }
		
		if(is_array($vignettes)) { 

            $return.="class=\"lazyload";
		    if($this->otherClass!="") { $return.=" " . $this->otherClass; }
    		$return.="\" "; // ferme attribut class
            
	    	if($this->dataSizes!="") { 
                $return.="data-sizes=\"" . $this->dataSizes ."\" "; 
            } else {
                $return.="data-sizes='auto' ";
            }
        
			if($this->adaptativeVigs[""]!="") { $return.="src=\"" . $vignettes[$this->adaptativeVigs[""]] ."\" "; }
			
			$srcset="data-srcset=\"";
			$sep="";
			foreach($this->adaptativeVigs as $limitWidth=>$indiceVignette){
				if($limitWidth!="") {
                 //   echo($limitWidth . "x" . $indiceVignette . "x" . $vignettes[$indiceVignette]  ."<br>");
					$srcset.=$sep . $vignettes[$indiceVignette] . " " . $limitWidth . "w"; 
					$sep=", ";
				}
			}
			$return .=$srcset . "\" ";
            
		} else { // sinon balise img normale
            
             $return.="class=\"imageN";
		    if($this->otherClass!="") { $return.=" " . $this->otherClass; }
    		$return.="\" "; // ferme attribut class
            
            $return.="src=\"" . $this->image ."\" ";

        }
        
		$return .="/>";
		
		
		return $return;
	}

	
} 
?>