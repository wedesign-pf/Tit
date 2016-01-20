<?php
class media {

	// création de l'objet
	public function __construct ($field) {
        
        if($field=="") { return false; }
        $this->field=$field;
        
        global $thisSite;
        
        // get()
        $this->idParent=0;
        $this->idMedia=0;
        $this->onlySelection=0;
        $this->orderby="chrono DESC";
        $this->sizeThumbVideo=0;
        // VALEURS POSSIBLES POUR YOUTUBE
        //   Définition Standard (640×480 pixels) : hqdefault
        //   [HD] Haute Définition (1920×1080 pixels) : sddefault
        //   Fond du Player (480×360 pixels) : 0
        //   Première image de la vidéo (120×90 pixels) : 1
        //   Deuxième image de la vidéo (120×90 pixels) : 2
        //   Dernière image de la vidéo (120×90 pixels) : 3
        //   [HQ] Haute Qualité (480×360 pixels) : hqdefault
        //   Qualité moyenne (320×180 pixels) : mqdefault
        //   Qualité normale (120×90 pixels) : default

        $type_video=$thisSite->TYPE_VIDEO_DEFAUT;

    }

    public function get() {

        global $thisSite;
    
        $mySelectM = new mySelect(__FILE__);
        $mySelectM->tables=$thisSite->PREFIXE_TBL_GEN . "medias";
        $mySelectM->fields="*";
        $mySelectM->orderby=$this->orderby;
        $mySelectM->where="actif=1 AND field_media='" . $this->field ."'";
        
        if($this->lg!="" && $this->lg!="all" ) { // si une langue est indiqué on l'utilise
			$mySelectM->where.=" AND lg='" . $this->lg . "'";
		} else if($this->lg=="" ) { 
            $mySelectM->where.=" AND lg='" . $thisSite->current_lang . "'";
        }
         
        if($this->idParent>0) {
            $mySelectM->where.=" AND id_parent=:idParent"; 
            $mySelectM->whereValue["idParent"]=array($this->idParent,PDO::PARAM_INT);
        }
        if($this->idMedia>0) {
            $mySelectM->where.=" AND id=:idMedia"; 
            $mySelectM->whereValue["idMedia"]=array($this->idMedia,PDO::PARAM_INT);
        }
        if($this->onlySelection>0) {
            $mySelectM->where.=" AND image_principale=1";
        }
        
        $resultM=$mySelectM->query();
        $allMedias=array();
    
        $x=1;
        foreach($resultM as $rowM){ 
    
            $temp=array();
            if($rowM["fichier_media"]=="" && $rowM["lien_destination"]=="") { continue; }
            
            $temp["id"]=$rowM["id"];
    
            if($rowM["type"]=="image") { 		
                $temp["image"]=$rowM["fichier_media"];
                
                for(  $indiceVignette = 0; $indiceVignette < 5; $indiceVignette++ ) {
                  $temp["vig".$indiceVignette]=get_vignette($rowM["fichier_media"],$indiceVignette);
                }

               $temp["legende"]=$rowM["titre_media"];
               $temp["fichier_destination"]=$rowM["fichier_destination"];
               $temp["lien_destination"]=$rowM["lien_destination"];
               $temp["cible_destination"]=$rowM["cible_destination"];
               $temp["image_principale"]=$rowM["image_principale"];
                
                
            }
            
            if($rowM["type"]=="file") { 		
                $temp["fichier"]=$rowM["fichier_media"];
                $temp["legende"]=$rowM["titre_media"];
                if($temp["legende"]=="") { $temp["legende"]=get_nom_fichier($rowM["fichier_media"]);}
            }
            
            if(strpos($rowM["type"], "video")===0) { 		
                $temp["lien_video"]=$rowM["fichier_media"];
                $temp["type_video"]=$rowM["type"];
                $temp["legende"]=$rowM["titre_media"];
                $temp["image_principale"]=$rowM["image_principale"];
                $temp["thumb"] = $this->imageVideo($rowM["type"],$rowM["fichier_media"],$this->sizeThumbVideo);
                $temp["player"] = $this->embedVideo($rowM["type"],$rowM["fichier_media"]);
            }
            
            if($rowM["type"]=="link") { 		
                $temp["lien"]=$rowM["lien_destination"];
                $temp["cible"]=$rowM["cible_destination"];
                $temp["legende"]=$rowM["titre_media"];
                if($temp["legende"]=="") { $temp["legende"]=get_nom_fichier($rowM["lien_destination"]);}
            }
    
            /*if($rowM["image_principale"]==1) {
                $allMedias[0]=$temp;
            } else {
                $allMedias[$x]=$temp;
                $x++;
            }*/
            
            $allMedias[$x]=$temp;
            $x++;
            
        }
        
        return $allMedias;
        
    } // get
    
    
    //https://coderwall.com/p/fdrdmg/get-a-thumbnail-from-a-vimeo-video
    //http://darcyclarke.me/development/get-image-for-youtube-or-vimeo-videos-from-url/
    //http://stackoverflow.com/questions/1361149/get-img-thumbnails-from-vimeo
    public function imageVideo($type_video,$lien_video,$size_videoThumb=0){
        
        global $thisSite;
        
        if(strpos($type_video, "YouTube")>0) { 
            return "http://img.youtube.com/vi/".$lien_video."/" . $size_videoThumb . ".jpg";
        }
    
        if(strpos($type_video, "Vimeo")>0) { 
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$lien_video.".php"));
            if($size_videoThumb==2) return $hash[0]["thumbnail_small"];
            if($size_videoThumb==1) return $hash[0]["thumbnail_medium"];
            if($size_videoThumb==0) return $hash[0]["thumbnail_large"];
        }
        
    } // imageVideo
    
    public function embedVideo($type_video,$lien_video){
        
        if(strpos($type_video, "YouTube")>0) { 
            return "https://www.youtube.com/embed/" . $lien_video;
        } 
        
        if(strpos($type_video, "Vimeo")>0) { 
            return "https://player.vimeo.com/video/" . $lien_video;
        } 
        
    } // embedVideo
    
   
} 

?>