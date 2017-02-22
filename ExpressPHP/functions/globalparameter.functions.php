<?php
function __GlobalParameters($VariableName = null){
	$VariablesModule = new VariablesModule();
	return $VariablesModule->Get($VariableName);
}

?>