<?php
$myTable="__exemple_form";
$actionsPage=array("appliquer");
$idCurrent=$thisSite->ID_SITE;
$actionsPage=array("appliquer");
$variablesAuthorized=true;
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php
//echoa($__POST);
////////////////////////////////////////////////////////////////
// formulaire
$formMaj = new formMaj();
$formMaj->tables=$myTable;
$formMaj->fields="*";
$formMaj->where="id=:id";
$formMaj->whereValue["id"]=array($idCurrent,PDO::PARAM_INT);
$formMaj->multiLang=true;
$formMaj->clause_where();

//echoa($__POST);
// si validation du formulaire
if($__POST["actionForm"]!="") {
	//$formMaj->fieldUpdate["nb_aff"]="LITERAL:nb_aff+1";
	//$formMaj->fieldInsert["todolist"]=date("His");
	$formMaj->set_datas();
}

// chargement des données
$formMaj->get_datas();
?>
<?php

///////////////////////////////
$listSkins=array();
$chem.= DOS_BASE_ADMIN . "css/";

$handle  = @opendir($chem);
while ($file = @readdir($handle)) {
	if(is_dir("$chem/$file") && $file!="." && $file!=".."  ) {
		$listSkins[$file]=$file;
		if($formMaj->datasForm[$myAdmin->LANG_DATAS]["skin"] == ""){ $formMaj->datasForm[$myAdmin->LANG_DATAS]["skin"]=$file; } // valeur par défaut
	}
}
$datas_page["listSkins"]=$listSkins;
?>
<?php
///////////////////////////////////
// champs de saisie
///////////////////////////////////

$newfield = new input();
$newfield->field="Finput";
$newfield->multiLang=true;
$newfield->label=$datas_lang["titre"];
$newfield->tooltip="tooltip";
$newfield->placeholder="placeholder";
$newfield->disabled=false;
$newfield->addClass="addClassTest"; // ne marche pas
$newfield->addStyleLabel="font-size:24px;"; 
$newfield->widthLabel=3;
$newfield->widthField=7;
$newfield->autocomplete=true;
$newfield->counter=20; //"countType:'characters', maxCount:10, strictMax:true";
$newfield->variablesAuthorized=true;
$newfield->value=array("fr"=>"FFFF","en"=>"EEEE");
$newfield->defaultValue=array("fr"=>"FFFF","en"=>"EEEE");
$newfield->javascript="onChange='test(this)'";
$newfield->add();
$newfield->rule("required",true);
//$newfield->rule("remote",array("script"=> "remoteTest.php","table"=>$myTable,"valOrigin"=>"FIELD:Finput","params"=>"x=xx"), $datas_lang["existedeja"]);

$newfield = new hidden();
$newfield->field="Fhidden";
$newfield->multiLang=true;
$newfield->value=array("fr"=>"FRXXXXXXXXX","en"=>"ENXXXXXXXXXXXXXXXX");
$newfield->defaultValue=array("fr"=>"FFFF","en"=>"EEEE");
$newfield->add();

$newfield = new password();
$newfield->field="Fpassword";
$newfield->label="mot de passe";
$newfield->tooltip="Que des chiffres et des lettres, sans espace ni caractères spéciaux";
$newfield->add();
$newfield->rule("alphanumeric",true);
$newfield->rule("minlength",5);
$newfield->rule("maxlength",20);
// password confirm
$newfield = new password();
$newfield->field="Fconfirm_password";
$newfield->label="Confirmation";
$newfield->value=$formMaj->datasForm[$myAdmin->LANG_DATAS]["password"];
$newfield->add();
$newfield->rule("equalTo","'#Fpassword'");

$newfield = new textarea();
$newfield->field="Ftextarea";
$newfield->multiLang=true;
$newfield->disabled=false;
$newfield->counter=20; //"countType:'characters', maxCount:10, strictMax:true";
$newfield->variablesAuthorized=false;
$newfield->placeholder="placeholder";
$newfield->widthField=4;
$newfield->rows=5;
$newfield->add();

$newfield = new radio();
$newfield->field="Fradio";
$newfield->label="Radio Bouton";
$newfield->multiLang=true;
$newfield->disabled=false;
$newfield->tooltip="tooltip";
$newfield->value=array("fr"=>"bb","en"=>"cc");
$newfield->defaultValue=array("fr"=>"cc","en"=>"dd");
$newfield->valuesDisabled=array("aa");
$newfield->items=array("aa"=>"AAAA","bb"=>"BBBB","cc"=>"CCCC","dd"=>"DDDD");
$newfield->noneItem=true; 
$newfield->allItems="all Items";
$newfield->add();

$newfield = new checkbox();
$newfield->field="Fcheckbox";
$newfield->label="Check box";
$newfield->multiLang=true;
$newfield->disabled=false;
$newfield->tooltip="tooltip";
$newfield->value=array("fr"=>"aa,bb","en"=>"cc");
$newfield->defaultValue=array("fr"=>"cc","en"=>"dd");
$newfield->valuesDisabled=array("dd");
$newfield->items=array("aa"=>"AAAA","bb"=>"BBBB","cc"=>"CCCC","dd"=>"DDDD");
//$newfield->noneItem=true; 
//$newfield->allItems="all Items";
$newfield->add();

$newfield = new select();
$newfield->field="Fselect";
$newfield->label="Select";
$newfield->multiLang=true;
$newfield->disabled=false;
$newfield->tooltip="tooltip";
$newfield->value=array("fr"=>"bb","en"=>"cc");
$newfield->defaultValue=array("fr"=>"cc","en"=>"dd");
$newfield->valuesDisabled=array("aa");
$newfield->items=array("aa"=>"AAAA","bb"=>"BBBB","cc"=>"CCCC","dd"=>"DDDD");
$newfield->noneItem=true; 
$newfield->allItems="all Items";
$newfield->widthField=3;
$newfield->add();

$newfield = new selectM();
$newfield->field="FselectM";
$newfield->label="Select Multiple";
$newfield->multiLang=false;
$newfield->disabled=false;
$newfield->tooltip="tooltip";
$newfield->tags=false;
$newfield->value="aa,bb"; // array("fr"=>"aa,bb","en"=>"aa");
//$newfield->defaultValue=array("1");
$newfield->valuesDisabled=array("10");
$newfield->items=array("aa"=>"AAAA","bb"=>"BBBB","cc"=>"CCCC","dd"=>"DDDD","ee"=>"EEEEE");
$newfield->multiple=false;
$newfield->selectAll=true;
$newfield->filter=true;
$newfield->minimumCountSelected=3;
$newfield->single=false;
$newfield->isOpen=false;
$newfield->keepOpen=false;
$newfield->placeholder="placeholder";
$newfield->add();

$newfield = new selectMCols();
$newfield->field="FselectMCols";
$newfield->label="Select Multiple Cols";
$newfield->multiLang=false;
$newfield->disabled=false;
$newfield->tooltip="tooltip";
$newfield->tags=true;
$newfield->value="aa,cc";
//$newfield->defaultValue=array("1");
$newfield->valuesDisabled=array("dd");
$newfield->items=array("aa"=>"AAAA","bb"=>"BBBB","cc"=>"CCCC","dd"=>"DDDD","ee"=>"EEEEE");
$newfield->selectAll=true;
$newfield->add();


// date seule
$newfield = new date();
$newfield->field="Fdate";
$newfield->label="Date seule";
$newfield->showButtonPanel=true;
$newfield->changeYear=true;
$newfield->numberOfMonths=1;
$newfield->minDate=-10;
$newfield->maxDate="+10M +2D";
$newfield->multiLang=false;
$newfield->value= date('Ymd', strtotime("+1 days")); //array("fr"=>date('Ymd', strtotime("+1 days")),"en"=>date('Ymd', strtotime("+10 days"))); //
$newfield->defaultValue= date('Ymd', strtotime("+20 days"));
$newfield->dateFormat="dd.mm.yy";
$newfield->disabled=false;
$newfield->tooltip="tooltip";
$newfield->add();

// période
$newfield = new periode();
$newfield->field="Fperiode";
$newfield->label="Période";
$newfield->showButtonPanel=false;
$newfield->changeYear=false;
$newfield->numberOfMonths=2;
$newfield->dateFormat="dd.mm.yy";
$newfield->minDate=-5;
$newfield->maxDate="+1Y +2D";
$newfield->disabled=false;
$newfield->multiLang=false;
$newfield->required="beg,end";
$newfield->valuesPeriode=array(date("Ymd"),date('Ymd', strtotime("+15 days")));
$newfield->valuesPeriode= array("fr"=>array(date("Ymd"),date('Ymd', strtotime("+15 days"))),"en"=>array(date("Ymd"),date('Ymd', strtotime("+55 days")))); //date('Ymd', strtotime("+1 days"));
//$newfield->defaultValuesPeriode=array(date("Ymd", strtotime("+1 days")),date('Ymd', strtotime("+100 days")));
$newfield->add();

$newfield = new rating();
$newfield->field="Frating";
$newfield->label="Rating";
$newfield->max=10;
$newfield->value=4;
$newfield->defaultValue=3;
$newfield->disabled=false;
$newfield->tooltip="tooltip";
$newfield->add();

$newfield = new slider();
$newfield->field="Fslider";
$newfield->label="Slider";
$newfield->value=array("fr"=>"30,100","en"=>"20");
$newfield->defaultValue="50,90";
$newfield->step=10;
$newfield->min=20;
$newfield->max=300;
$newfield->tooltip="tooltip";
$newfield->multiLang=true;
$newfield->disabled=false;
$newfield->add();

$newfield = new editor();
$newfield->field="Feditor";
$newfield->label="Editor";
$newfield->multiLang=false;
$newfield->widthField=8;
$newfield->height=200;
$newfield->value=array("fr"=>"FRxxééééxx","en"=>"ENxxxx");
$newfield->defaultValue="eeeeeeeee";
$newfield->tooltip="tooltip";
$newfield->toolbar="Default";
$newfield->startFolder="test";
$newfield->extensionsAuthorized="images";
$newfield->variablesAuthorized=true; 
$newfield->dimMax="500x400";
$newfield->dimThumbs=array("100x100","200x");
$newfield->upload=true;
$newfield->disabled=false;
$newfield->add();
$newfield->rule("required",true);//http://www.aliaspooryorik.com/blog/index.cfm/e/posts.details/post/using-jquery-validate-plugin-with-ckeditor-396

$newfield = new file();
$newfield->field="Ffile";
$newfield->label="File";
$newfield->multiLang=true;
$newfield->variablesAuthorized=true; 
$newfield->vaxlue=array("fr"=>"FxxxR","en"=>"EN");
$newfield->defaultValue="eeeeeeeee";
$newfield->placeholder="placeholder";
$newfield->tooltip="tooltip";
$newfield->startFolder="test";
$newfield->dimMax="500x400";
$newfield->dimThumbs=array("100x100","200x");
$newfield->extensionsAuthorized="jpg,png,zip";
$newfield->upload=true;
$newfield->browse=true;
$newfield->disabled=false;
$newfield->showImage=true;
//$newfield->javascript="onChange='alert(\"ddddd\")'";
$newfield->add();

$fieldMedia = new mediaImage();
$fieldMedia->field="FmediaImage";
$fieldMedia->label=$datas_lang["image"];
$fieldMedia->fileRequired=false;
$fieldMedia->insideForm=true;
$fieldMedia->startFolder="test"; // sous répertoide de Files
$fieldMedia->actionDestination="link"; // "file" ou "link" ou rien : Destination d'un click
$fieldMedia->multiLangType=true; // langues du champ fichier
$fieldMedia->multiLangDestination=true; // langues des champs destination 
$fieldMedia->extensionsAuthorized=""; //  si vide > auto les ext. par défaut sinon indiquer une chaine > exemple: "jpg,png,zip"
$fieldMedia->dimMax="600x400"; // dimension Max des fichiers images
$fieldMedia->dimThumbs=array("100x100","200x200"); // dimension des vignettes à créer
$fieldMedia->legendeEnabled=true;
$fieldMedia->add();

$fieldMedia = new mediaFile();
$fieldMedia->field="FmediaFile";
$fieldMedia->label=$datas_lang["fichier"];
$fieldMedia->fileRequired=false;
$fieldMedia->insideForm=true;
$fieldMedia->startFolder="test"; // sous répertoide de Files
$fieldMedia->multiLangType=true; // langues du champ fichier
$fieldMedia->extensionsAuthorized=""; //  si vide > auto les ext. par défaut sinon indiquer une chaine > exemple: "jpg,png,zip"
$fieldMedia->legendeEnabled=true;
$fieldMedia->add();

$fieldMedia = new mediaLink();
$fieldMedia->field="FmediaLink";
$fieldMedia->label=$datas_lang["lien"];
$fieldMedia->fileRequired=false;
$fieldMedia->insideForm=true;
$fieldMedia->multiLangType=true; // langues du champ fichier
$fieldMedia->legendeEnabled=true;
$fieldMedia->add();

$fieldMedia = new mediaVideo();
$fieldMedia->field="FmediaVideo";
$fieldMedia->label=$datas_lang["lienVideo"];
$fieldMedia->multiLangType=true; // langues du champ fichier
$fieldMedia->insideForm=true;
$fieldMedia->fileRequired=false;
$fieldMedia->legendeEnabled=true;
$fieldMedia->tooltip="Exemple: 5guMumPFBag";
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>