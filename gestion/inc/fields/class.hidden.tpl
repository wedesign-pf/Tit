{foreach $this->list_lang as $clg=>$extlg}

	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}

	<input name='{$fieldLg}' id='{$fieldLg}' type='hidden' {$this->str_variablesAuthorized} value='{$valueField}'  >

{/foreach}