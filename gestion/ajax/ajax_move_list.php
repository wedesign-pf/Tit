<?php
$pathBatch="../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php
//echo($_POST['table'] . "=" . $_POST['prev'] . ">" . $_POST['item'] . "<" . $_POST['next']);

$resultx = $PDO->free_requete("SELECT chrono FROM " . $_POST['table'] . " WHERE id=" . $_POST['item'] );
$rowx = $resultx->fetch();
$chronoItem=$rowx["chrono"];
//echo("=" . $chronoItem);

$resultx = $PDO->free_requete("SELECT chrono FROM " . $_POST['table'] . " WHERE id=" . $_POST['prev'] );
$rowx = $resultx->fetch();
$chronoPrev=$rowx["chrono"];
//echo("=" . $chronoPrev);

$resultx = $PDO->free_requete("SELECT chrono FROM " . $_POST['table'] . " WHERE id=" . $_POST['next'] );
$rowx = $resultx->fetch();
$chronoNext=$rowx["chrono"];
//echo("=" . $chronoNext);

list($intPrev, $floatPrev)=explode(".", $chronoPrev);

$offset=0.1;
for($i=0;$i<count(floatPrev);$i++) {
	$offset=$offset*0.1;
}

$newChrono=$chronoPrev+$offset;
$resultx = $PDO->free_requete("UPDATE " . $_POST['table'] . " SET chrono=" . $newChrono . " WHERE id=" . $_POST['item'] );

?>

