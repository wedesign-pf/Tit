<?php
// On appelle la session
if (session_id() == "") session_start();

// On écrase le tableau de session
$_SESSION = array();

// On détruit la session
session_destroy();

?>
<script language="javascript">window.location.href='index.php'</script>  