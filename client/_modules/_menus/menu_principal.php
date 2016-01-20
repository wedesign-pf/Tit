<?php
$menu="principal";
$menuPages =$thisSite->menus[$menu];
//
//echoa($menuPages);
/////////////////////////////////////////////////
foreach($menuPages as $idRUB=>$listSRUB) {
	//echoa($idRUB);
	//echoa($listSRUB);
	// niveau Rubrique
	$datasRUB = $thisSite->pages[$idRUB];
    $lienRub=$datasRUB["page_url_menu"][$menu];
    
	// si page en cours
	if($idRUB==$thisSite->current_rub) { 
		$classLI="rubA" . $datasRUB["classLI"]; 
	    $classA = ""; 
	} else {
        $classLI="rub";
	    $classA = ""; 
    }
    
    $classLI.=$datasRUB["classLI"]; 
    $classA.=$datasRUB["classA"]; 
	
	if($idRUB==10) { $datasRUB["titre"]="<i class='fa fa-15x fa-home'></i>"; } //

	// chargement du contenu des sous rubriques
	$SRUBS=array();
	if(is_array($listSRUB) && $datasRUB["show_sousmenu"]==1) { 
		if(count($listSRUB)>0) { 
			foreach($listSRUB as $idSRUB=>$listSSRUB) { 
				$datasSRUB = $thisSite->pages[$idSRUB];
   				$tempS=array();
				$tempS["id"]=$idSRUB;
				$tempS["titre"]=$datasSRUB["titre"];
                $tempS["lien"]=$datasSRUB["page_url_menu"][$menu];
                $tempS["classLI"]="srub" . $datasSRUB["classLI"];
                $tempS["classA"]=$datasSRUB["classA"]; 
				// chargement du contenu des sous sous rubriques
				$sRubs=array();
				if(is_array($listSSRUB)) { 
					if(count($listSSRUB)>0) { 
						foreach($listSSRUB as $idSSRUB=>$nada) { 
							$datasSSRUB = $thisSite->pages[$idSSRUB];
                            $tempSS=array();
							$tempSS["id"]=$idSSRUB;
							$tempSS["titre"]=$datasSSRUB["titre"];
                            $tempSS["lien"]=$datasSSRUB["page_url_menu"][$menu];
                            $tempSS["classLI"]="ssrub" . $datasSSRUB["classLI"];
                            $tempSS["classA"]=$datasSSRUB["classA"]; 
							$sRubs[]=$tempSS;
						}
					}
				} 
				$tempS["sRubs"]=$sRubs;
				$SRUBS[]=$tempS;
			}
		}
	}

//echoa($SRUBS);
	$RUBS=array();
	$RUBS["id"]=$idRUB;
	$RUBS["classLI"]=$classLI;
	$RUBS["classA"]=$classA;
	$RUBS["lien"]=$lienRub;
    $RUBS["page_type"]=$datasRUB["page_type"];
    $RUBS["page_url"]=$datasRUB["page_url"];
	$RUBS["titre"]=$datasRUB["titre"];
    $RUBS["explications"]=$datasRUB["explications"];
    $RUBS["couleur"]=$datasRUB["couleur"];
	$RUBS["SRUBS"]=$SRUBS;

	add_plan_du_site($menu,$idRUB,$lienRub,$datasRUB["titre"],$SRUBS);

	$smarty->append("RUBS",$RUBS);

}
?>