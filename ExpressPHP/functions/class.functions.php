<?php
/**
 * 获取PHP类的最上级父级类名
 * 如果指定 $TopClassName 时,将认为 $TopClassName 最终的顶级类而中止继续向上获取.
 *
 * @param String $ClassName
 * @param String $TopClassName
 * @return String
 */
function Class_Get_TopClassName($ClassName, $TopClassName = 'ExpressPHP_VIEWER') {
	$Result = class_parents ( new $ClassName ( ) );
	if (is_array ( $Result ) && count ( $Result )) {
		list ( $ParentClassName, $ParentClassName ) = each ( $Result );
		if ($ParentClassName == $TopClassName) {
			return false;
		} else {
			$ParentResult = Class_Get_TopClassName ( $ParentClassName, $TopClassName );
			if ($ParentResult) {
				return $ParentResult;
			} else {
				return $ParentClassName;
			}
		}
	} else
		return $ClassName;
}

/**
 * 获取指定类名的类的所有函数(方法)
 *
 * @param string $ClassName
 * @return array
 */
function Class_Get_Functions($ClassName) {
	$class_methods = get_class_methods ( $ClassName );
	if (is_array ( $class_methods )) {
		foreach ( $class_methods as $method_name ) {
			$func[ ] = $method_name;
		}
		return $func;
	}
}
/**
 * 获取父级的所有函数
 *
 * @param string $ClassName
 * @return array
 */
function Class_Get_Parent_Functions($ClassName){
	$Result = class_parents ( new $ClassName ( ) );
	if (is_array ( $Result ) && count ( $Result )) {
		list ( $ParentClassName, $ParentClassName ) = each ( $Result );
		return Class_Get_Functions($ParentClassName);
	}
	else {
		return false;
	}
}
function Class_Get_Current_Functions($ClassName){
	$funcs = Class_Get_Functions($ClassName);
	$funcs_parent = Class_Get_Parent_Functions($ClassName);
	return array_diff($funcs, $funcs_parent);
}
?>