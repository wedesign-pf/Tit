<?php 
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "menus";
	$mySelect->fields="code_menu";
	$mySelect->where="lg=:lg AND actif=1";
	$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
	$mySelect->orderby="chrono ASC";
	$result=$mySelect->query();
	foreach($result as $row){ 
		$code = "menu_" . $row['code_menu'];
		$obj_module = new module("menus",$code);
		$obj_module->load();
	}

//echoa($thisSite->siteMap); 
?>
<?php
header("Content-Type: text/xml;charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
?>
<?php // on écrit 1er URL: celle du site
echo "<url>\n<loc>" . $thisSite->racineWithLang . "</loc>\n<priority>1.0</priority>\n<changefreq>weekly</changefreq>\n</url>\n";
?>
<?php 

foreach($thisSite->siteMap as $code_menu=> $tab_menu) {

	foreach($tab_menu as $tab_rub) {

		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
		$mySelect->fields="*";
		$mySelect->where="id=:id AND actif=1 and lg=:lg";
		$mySelect->whereValue["id"]=array($tab_rub["id_rub"],PDO::PARAM_INT);
		$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
		$result=$mySelect->query();
		$row=current($result);

		$id_rub = $row['id'];
		$sitemap_priority = $row['page_sitemap_priority'];
		$sitemap_changefreq = $row['page_sitemap_changefreq'];
		$page_type = $row['page_type'];

		if(!in_array($page_type,$thisSite->PAGES_FULL)) { continue; }

		if($sitemap_priority=="" || $sitemap_priority=="oto" ) {
			if($code_menu=="principal") { $sitemap_priority="0.9"; } else { $sitemap_priority="0.7"; }
		}
		if($sitemap_changefreq=="") { $sitemap_changefreq="monthly"; }
		
		if(stristr($tab_rub["lien_rub"],"javascript")===FALSE) {
			echo "<url>\n<loc>" . $thisSite->racineWithLang . $tab_rub["lien_rub"] . "</loc>\n<priority>$sitemap_priority</priority>\n<changefreq>$sitemap_changefreq</changefreq>\n</url>\n";	
		}
		
		if(count($tab_rub["SRUBS"])>0) {
			
			foreach($tab_rub["SRUBS"] as $id_srub=> $tab_srub) { 
				list($titre_srub,$lien_srub) = $tab_srub;

				$mySelect2 = new mySelect(__FILE__);
				$mySelect2->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
				$mySelect2->fields="*";
				$mySelect2->where="id=:id AND actif=1 and lg=:lg";
				$mySelect2->whereValue["id"]=array($id_srub,PDO::PARAM_INT);
				$mySelect2->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
				$result2=$mySelect2->query();
				$row2=current($result2);
				
				$sitemap_priority = $row2['page_sitemap_priority'];
				$sitemap_changefreq = $row2['page_sitemap_changefreq'];
				
				if($sitemap_priority=="") { $sitemap_priority="0.5"; }
				if($sitemap_changefreq=="") { $sitemap_changefreq="monthly"; }
			
				if($tab_srub["lien"]!="") { 
					echo "<url>\n<loc>" . $thisSite->racineWithLang . $tab_srub["lien"] . "</loc>\n<priority>$sitemap_priority</priority>\n<changefreq>$sitemap_changefreq</changefreq>\n</url>\n";
				}
				
			}

		}
		
	}

}
?>
<?php
echo '</urlset>';
?>