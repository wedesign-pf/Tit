<?php
$smarty->assign("listCols", $listCols);
$smarty->assign("listRow", $listRow);
//$smarty->assign("listChronos", $listChronos);
$smarty->assign("myTable", $myTable);
$smarty->assign("boutons", $boutons);
$smarty->assign("clauseWhere", urlencode($formList->where));


$listCols[$col]["clauseWhere"]=$mySelect->where;
// on interdit l'ajout si nombre max dépassé
if($count_datas >= $maxElements && $maxElements>0) { RemoveActionPage("ajouter"); RemoveActionPage("dupliquer"); }
?>