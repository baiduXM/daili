<?php
/**
 *  ExpressPHP Template 模板解析类
 * 	开发者: Leslie X 3.0(204966@qq.com)
 * 	最后修改: 2009-07-04
 *
 */
class ExpressPHP_Template {
	//用于继承全局变量
	public $Variables = array ();
	private $Version = '3.0.0 beta';
	const NORMAL = 'normal';
	const MANUAL = 'manual';
	const DEBUG = 'debug';
	public $Config = array (
		'GlobalsAutoImport' => true, 
		'CompilerMode' => 'normal',  //normal,manual,debug
		'TemplatePath' => '/Templates', 
		'TemplateCompiledPath' => '/Data/TemplatesCompiled', 
		'TemplateDefaultPath' => null, 
		'DocumentRoot' => null, 
		'TemplateFileExt' => '.htm', 
		'TemplateCompiledFileExt' => '.tpl.php' 
	);
	
	public function __construct($tmpConfig = null) {
		$this->__ConfigImport ( $tmpConfig );
		if (get_class () != get_class ( $this )) {
			$tmpConfig = $this->__Config ();
			$this->__ConfigImport ( $tmpConfig );
			unset ( $tmpConfig );
		}
		$this->__CheckPath ();
	}
	private function __ConfigImport($tmpConfig = null) {
		if (is_array ( $tmpConfig )) {
			foreach ( $tmpConfig as $key => $value ) {
				if (array_key_exists ( $key, $this->Config ))
					$this->Config[ $key ] = $value;
			}
		
		}
	}
	/**
	 * 检查DocumentRoot/TemplateCompiledPath/TemplateDefaultPath路径
	 *
	 */
	private function __CheckPath() {
		if (! $this->Config[ 'DocumentRoot' ] || ! file_exists ( $this->Config[ 'DocumentRoot' ] )) {
			die ( 'The template \'s configuration failed[DocumentRoot]!' );
		}
		//检查模板编译目录是否存在，不存在，将尝试创建;
		if ($this->Config[ 'TemplatePath' ]) {
			if (! file_exists ( $this->Config[ 'DocumentRoot' ] . $this->Config[ 'TemplateCompiledPath' ] . $this->Config[ 'TemplatePath' ] )) {
				$this->__mkdirs ( $this->Config[ 'TemplateCompiledPath' ] . $this->Config[ 'TemplatePath' ], $this->Config[ 'DocumentRoot' ] );
			}
		} else if (! $this->Config[ 'TemplatePath' ] || ! file_exists ( $this->Config[ 'TemplatePath' ] )) {
			die ( 'The template \'s configuration failed[TemplatePath]!' );
		}
		if ($this->Config[ 'TemplateDefaultPath' ]) {
			if (! file_exists ( $this->Config[ 'DocumentRoot' ] . $this->Config[ 'TemplateCompiledPath' ] . $this->Config[ 'TemplateDefaultPath' ] )) {
				$this->__mkdirs ( $this->Config[ 'TemplateCompiledPath' ] . $this->Config[ 'TemplateDefaultPath' ], $this->Config[ 'DocumentRoot' ] );
			}
		}
	}
	/**
	 * 用于手动编译配置上的模板目录中所有模板文件
	 *
	 * @param array $tmpConfig
	 */
	public function __CompileAllTemplates($tmpConfig = null) {
		
		if (is_array ( $tmpConfig )) {
			$this->__ConfigImport ( $tmpConfig );
			if (get_class () == get_class ( $this )) {
				$this->__CheckPath ();
			}
		}
		$config = $this->Config;
		$tmpTemplateFileExt = $config[ 'TemplateFileExt' ];
		if ($config[ 'TemplatePath' ]) {
			$tmpPath = $config[ 'DocumentRoot' ] . $config[ 'TemplatePath' ];
			$d = dir ( $tmpPath );
			while ( false !== ($entry = $d->read ()) ) {
				if ($entry != "." && $entry != "..") {
					if (is_file ( $tmpPath . '/' . $entry )) {
						if (substr ( $entry, - (strlen ( $tmpTemplateFileExt )) ) == $tmpTemplateFileExt) {
							$tpl = substr ( $entry, 0, - (strlen ( $tmpTemplateFileExt )) );
							$template_file = $config[ 'DocumentRoot' ] . $config[ 'TemplatePath' ] . '/' . $tpl . $config[ 'TemplateFileExt' ];
							$template_compiled_file = $config[ 'DocumentRoot' ] . $config[ 'TemplateCompiledPath' ] . $config[ 'TemplatePath' ] . '/' . $tpl . $config[ 'TemplateCompiledFileExt' ];
							$this->__Compiler ( $tpl, $template_file, $template_compiled_file );
						}
					}
				}
			}
			$d->close ();
			unset ( $d );
		
		}
		if ($config[ 'TemplateDefaultPath' ]) {
			$tmpPath = $config[ 'DocumentRoot' ] . $config[ 'TemplateDefaultPath' ];
			$d = dir ( $tmpPath );
			while ( false !== ($entry = $d->read ()) ) {
				if ($entry != "." && $entry != "..") {
					if (is_file ( $tmpPath . '/' . $entry )) {
						if (substr ( $entry, - (strlen ( $tmpTemplateFileExt )) ) == $tmpTemplateFileExt) {
							$tpl = substr ( $entry, 0, - (strlen ( $tmpTemplateFileExt )) );
							$template_file = $config[ 'DocumentRoot' ] . $config[ 'TemplateDefaultPath' ] . '/' . $tpl . $config[ 'TemplateFileExt' ];
							$template_compiled_file = $config[ 'DocumentRoot' ] . $config[ 'TemplateCompiledPath' ] . $config[ 'TemplateDefaultPath' ] . '/' . $tpl . $config[ 'TemplateCompiledFileExt' ];
							$this->__Compiler ( $tpl, $template_file, $template_compiled_file );
						}
					}
				}
			}
			$d->close ();
			unset ( $d );
		}
	}
	
	public function __destruct() {
		unset ( $this );
	}
	
	public function __get($varibale_name) {
		if (isset ( $this->Variables[ $varibale_name ] )) {
			return $this->Variables[ $varibale_name ];
		} else {
			return false;
		}
	}
	
	public function __setVariables($Variables, $VariableValue = null) {
		if (is_array ( $Variables )) {
			foreach ( $Variables as $key => $value ) {
				$this->Variables[ $key ] = $value;
			}
		} else {
			$this->Variables[ $Variables ] = $VariableValue;
		}
	}
	
	public function __clear() {
		$this->Variables = array ();
	}
	
	public function __set($varibale_name, $varibale_value) {
		$this->Variables[ $varibale_name ] = $varibale_value;
	}
	
	public function __isset($varibale_name) {
		return isset ( $this->Variables[ $varibale_name ] );
	}
	
	public function __unset($varibale_name) {
		unset ( $this->Variables[ $varibale_name ] );
	}
	public function __HTML($tpl, $force_compile = false) {
		ob_start ();
		$this->Display ( $tpl, $force_compile );
		$html = ob_get_contents ();
		ob_clean ();
		return $html;
	}
	public function Display($tpl) {
		if ($this->Config[ 'GlobalsAutoImport' ]) {
			unset ( $GLOBALS[ '_POST' ], $GLOBALS[ '_GET' ], $GLOBALS[ '_COOKIE' ], $GLOBALS[ '_ENV' ], $GLOBALS[ '_FILES' ], $GLOBALS[ '_REQUEST' ], $GLOBALS[ '_SERVER' ], $GLOBALS[ '_SESSION' ] );
			extract ( $GLOBALS, EXTR_OVERWRITE );
		}
		extract ( $this->Variables, EXTR_OVERWRITE );
		
		if (! $this->Config || ! $this->Config[ 'TemplatePath' ] || ! $this->Config[ 'DocumentRoot' ])
			die ( 'The Template parameter setting error.' );
		$template_file = $this->Config[ 'DocumentRoot' ] . $this->Config[ 'TemplatePath' ] . '/' . $tpl . $this->Config[ 'TemplateFileExt' ];
		$template_compiled_file = $this->Config[ 'DocumentRoot' ] . $this->Config[ 'TemplateCompiledPath' ] . $this->Config[ 'TemplatePath' ] . '/' . $tpl . $this->Config[ 'TemplateCompiledFileExt' ];
		
		if ($this->Config[ 'TemplateDefaultPath' ]) {
			$default_template_file = $this->Config[ 'DocumentRoot' ] . $this->Config[ 'TemplateDefaultPath' ] . '/' . $tpl . $this->Config[ 'TemplateFileExt' ];
			$default_template_compiled_file = $this->Config[ 'DocumentRoot' ] . $this->Config[ 'TemplateCompiledPath' ] . $this->Config[ 'TemplateDefaultPath' ] . '/' . $tpl . $this->Config[ 'TemplateCompiledFileExt' ];
		}
		
		if (file_exists ( $template_file )) { //
			//compile template file.
			$IsCompiled = true;
			if (! file_exists ( $template_compiled_file )) {
				$IsCompiled = false;
			} elseif (@filemtime ( $template_file ) > @filemtime ( $template_compiled_file )) {
				if ($this->Config[ 'CompilerMode' ] == self::NORMAL)
					$IsCompiled = false;
				elseif ($this->Config[ 'CompilerMode' ] == self::MANUAL) {
					$IsCompiled = true;
				} else
					$IsCompiled = false;
			}
			if ($this->Config[ 'CompilerMode' ] == self::DEBUG)
				$IsCompiled = false;
			if (! $IsCompiled) {
				$this->__Compiler ( $tpl, $template_file, $template_compiled_file );
			}
			include $template_compiled_file;
		
		} elseif ($this->Config[ 'TemplateDefaultPath' ] && file_exists ( $default_template_file )) {
			//compile default template file
			$IsCompiled = true;
			if (! file_exists ( $default_template_compiled_file )) {
				$IsCompiled = false;
			} elseif (@filemtime ( $default_template_file ) > @filemtime ( $default_template_compiled_file )) {
				if ($this->Config[ 'CompilerMode' ] == self::NORMAL)
					$IsCompiled = false;
				elseif ($this->Config[ 'CompilerMode' ] == self::MANUAL) {
					$IsCompiled = true;
				} else
					$IsCompiled = false;
			}
			if ($this->Config[ 'CompilerMode' ] == self::DEBUG)
				$IsCompiled = false;
			if (! $IsCompiled) {
				$this->__Compiler ( $tpl, $default_template_file, $default_template_compiled_file );
			}
			
			include $default_template_compiled_file;
		} else {
			die ( "The template file '" . $tpl . $this->Config[ 'TemplateFileExt' ] . "' not found or have no access!(1)" );
		}
	}
	private function __Load($tpl, $tplfile) {
		if (! @$fp = fopen ( $tplfile, 'r' )) {
			die ( "The template file '" . $tpl . $this->Config[ 'TemplateFileExt' ] . "' not found or have no access!(2)" );
		}
		$template_sources = fread ( $fp, filesize ( $tplfile ) );
		fclose ( $fp );
		unset ( $fp );
		return $template_sources;
	}
	
	public function __Compiler($tpl, $template_file, $template_compiled_file) {
		$template_sources = $this->__Load ( $tpl, $template_file );
		if (! $template_sources) {
			die ( "The template file '" . $tpl . $this->Config[ 'TemplateFileExt' ] . "' not found or have no access!" );
		}
		$template_sources = strtr ( $template_sources, array (
			"\n\n" => "\n", 
			"\r\r" => "\r" 
		) );
		
		$template_sources = preg_replace ( "/(\<\!|\/\/)\-\-\{(.+?)\}\-\-(\>|\/\/)/s", "{\\2}", $template_sources );
		//variables
		$template_sources = preg_replace ( "/[\n\r\t]*\{(\\\$[a-zA-Z0-9_\,\[\]\'\"\-\>\(\)\$\.\x7f-\xff]+)\}[\n\r\t]*/es", "'<?php echo '.self::__varscompiler('\\1').';?>'", $template_sources );
		//conset
		$template_sources = preg_replace ( "/[\n\r\t]*\{([A-Z\_][a-zA-Z0-9_\x7f-\xff]+)\}[\n\r\t]*/es", "self::__stripvtags('<?php echo \\1; ?>','')", $template_sources );
		//Label: template
		$template_sources = preg_replace ( "/[\n\r\t]*\{template\s+(|\"|')([^\}]+)(|\"|')\}[\n\r\t]*/is", "<?php \$this->Display(\"\\2\"); ?>", $template_sources );
		//Label: eval or php
		$template_sources = preg_replace ( "/[\n\r\t]*\{(eval|php)\s+(.+?)(|;)\}[\n\r\t]*/ies", "self::__stripvtags('<?php \\2; ?>','')", $template_sources );
		//Label: echo
		$template_sources = preg_replace ( "/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/ies", "self::__stripvtags('<?php echo \\1; ?>','')", $template_sources );
		//Label: sprintf
		$template_sources = preg_replace ( "/[\n\r\t]*\{sprintf\s+(.+?)\}[\n\r\t]*/ies", "self::__stripvtags('<?php echo sprintf(\\1); ?>','')", $template_sources );
		//Label: cycle
		$template_sources = preg_replace ( "/[\n\r\t]*\{cycle\s+values\=(\"|')(.+?)(\"|')\}[\n\r\t]*/ies", "self::__stripvtags('<?php echo self::__cycle(\\1\\2\\3, \$_this); ?>','')", $template_sources );
		//Label: htmlencode
		$template_sources = preg_replace ( "/[\n\r\t]*\{htmlencode\s+(.+?)\}[\n\r\t]*/is", "<?php echo self::__htmlspecialchars(\\1); ?>", $template_sources );
		//Label: htmlencode
		$template_sources = preg_replace ( "/[\n\r\t]*\{htmlencode_textarea\s+(.+?)\}[\n\r\t]*/is", "<?php echo self::__htmlencode_textarea(\\1); ?>", $template_sources );
		//Label: urlencode
		$template_sources = preg_replace ( "/[\n\r\t]*\{urlencode\s+(.+?)\}[\n\r\t]*/is", "<?php echo urlencode(\\1); ?>", $template_sources );
		//Label: lang
		$template_sources = preg_replace ( "/[\n\r\t]*\{lang\s+(|\"|')(.+?)(|\"|')\}[\n\r\t]*/is", "<?php echo self::__lang(\\1\\2\\3); ?>", $template_sources );
		
		//Label: elseif
		$template_sources = preg_replace ( "/[\n\r\t]*\{elseif\s+([^\}]+)\}[\n\r\t]*/ies", "self::__stripvtags('<?php } elseif(\\1) { ?>','')", $template_sources );
		//Label: else
		$template_sources = preg_replace ( "/[\n\r\t]*\{else\}[\n\r\t]*/is", "<?php } else { ?>", $template_sources );
		//Label: datasource
		$template_sources = preg_replace ( "/[\n\r\t]*\{datasource\s+(.+?)\}[\n\r\t]*/ies", "self::__template_datasource('\\1')", $template_sources );
		//Label: format
		$template_sources = preg_replace ( "/[\n\r\t]*\{format\s+(.+?)\}[\n\r\t]*/ies", "self::__template_format('\\1')", $template_sources );
		//Label: format
		$template_sources = preg_replace ( "/[\n\r\t]*\{templatecode\s+(.+?)\}[\n\r\t]*/ies", "self::__template_code('\\1')", $template_sources );
		for($i = 0; $i < 5; $i ++) {
			//Label: loop
			$template_sources = preg_replace ( "/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r]*(.+?)[\n\r]*\{\/loop\}[\n\r\t]*/ies", "self::__stripvtags('\n<?php \$__view__data__{$i}__=\\1;if(is_array(\$__view__data__{$i}__)) { foreach(\$__view__data__{$i}__ as \\2) { ?>','\n\\3\n<?php } } ?>\n','')", $template_sources );
			$template_sources = preg_replace ( "/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/loop\}[\n\r\t]*/ies", "self::__stripvtags('\n<?php \$__view__data__{$i}__{$i}__=\\1;  if(is_array(\$__view__data__{$i}__{$i}__)) { foreach(\$__view__data__{$i}__{$i}__ as \\2 => \\3) { ?>','\n\\4\n<?php } }  ?>\n','')", $template_sources );
		}
		$template_sources = preg_replace ( "/[\n\r\t]*\{if\s+([^\}]+)\}[\n\r]*/ies", "self::__stripvtags('<?php if(\\1) { ?>')", $template_sources );
		$template_sources = preg_replace ( "/[\n\r]*\{\/if\}[\n\r\t]*/ies", "self::__stripvtags('<?php } ?>')", $template_sources );
		//Label: nodisplay
		$template_sources = preg_replace ( "/\s*\{nodisplay\}\s*(.+?)\s*\{\/nodisplay\}\s*/ies", " ", $template_sources );
		$template_sources = preg_replace ( "/ \?\>[\n\r]*\<\?php /s", " ", $template_sources );
		
		if (! $this->__Save ( $tpl, $template_compiled_file, $template_sources ))
			return 0;
		else {
			die ( 'The template file "' . $tpl . $this->Config[ 'TemplateFileExt' ] . " compiled failed!" );
		}
	}
	private function __Save($tpl, $path, $template_sources) {
		$copyright = "<?php\r\n/*\r\n" . " ExpressPHP Template Compiler " . $this->Version . "\r\n compiled from " . $tpl . $this->Config[ 'TemplateFileExt' ] . " at " . date ( "Y-m-d H:i:s e" ) . "\r\n*/\r\n" . '?>';
		$template_sources = $copyright . $template_sources;
		
		$objfile = $path;
		if (! @$fp = fopen ( $objfile, 'w' )) {
			die ( "Directory '" . $this->Config[ 'TemplateCompiledPath' ] . "' not found or have no access!" );
		}
		flock ( $fp, 2 );
		fwrite ( $fp, $template_sources );
		fclose ( $fp );
		return 0;
	}
	
	static function __lang($langid) {
		if (! function_exists ( 'lang' ))
			return $langid;
		return lang ( $langid );
	}
	static function __template_format($string) {
		$string = strtr ( $string, array (
			'\"' => '"' 
		) );
		$fix_propertys = array (
			'type', 
			'style', 
			'value' 
		);
		if (preg_match_all ( "/([a-zA-Z_]+)=('|\")(.+?)('|\")/ies", $string, $m, PREG_SET_ORDER )) {
			foreach ( $m as $list ) {
				if (in_array ( $list[ 1 ], $fix_propertys )) {
					$fix_property[ $list[ 1 ] ] = $list[ 3 ];
					if ($list[ 1 ] === 'date') {
						$quote = $list[ 2 ];
					}
				}
			}
			if (! $fix_property[ 'type' ] || ! $fix_property[ 'value' ]) {
				return $string;
			}
			if (substr ( $fix_property[ 'value' ], 0, 1 ) !== '$' && preg_match ( '/^([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\(.+?\))$/', $fix_property[ 'value' ] )) {
				$fix_property[ 'value' ] = $quote . $fix_property[ 'value' ] . $quote;
			}
			if ($fix_property[ 'type' ] === 'date') {
				$string = '<?php echo date("' . $fix_property[ 'style' ] . '",' . $fix_property[ 'value' ] . '); ?>';
			}
			if ($fix_property[ 'type' ] === 'number') {
				$string = '<?php echo sprintf("' . $fix_property[ 'style' ] . '",' . $fix_property[ 'value' ] . '); ?>';
			}
			if ($fix_property[ 'type' ] === 'money') {
				$string = '<?php echo number_format(' . $fix_property[ 'value' ] . ', 2, \'.\', \'\'); ?>';
			}
			return $string;
		}
		return $string;
	}
	static function __template_code($string){
		return '{'.$string.'}';
	}
	static function __template_datasource($string) {
		$string = strtr ( $string, array (
			'\"' => '"' 
		) );
		$fix_propertys = array (
			'setvariable' 
		);
		if (preg_match_all ( "/([a-zA-Z_]+)=\"(.+?)\"/ies", $string, $m, PREG_SET_ORDER )) {
			foreach ( $m as $list ) {
				if (! in_array ( $list[ 1 ], $fix_propertys ))
					$property[ $list[ 1 ] ] = $list[ 2 ];
				else
					$fix_property[ $list[ 1 ] ] = $list[ 2 ];
			}
			if (! $fix_property[ 'setvariable' ] || ! $property[ 'function' ]) {
				return $string;
			}
			$string = '<?php ' . $fix_property[ 'setvariable' ] . '=self::__template_functions(' . self::__template_var_export ( $property ) . ');?>';
			return $string;
		}
		return $string;
	}
	
	static function __template_var_export($arr) {
		if (is_array ( $arr )) {
			foreach ( $arr as $key => $value ) {
				if (substr ( $value, 0, 1 ) === '$') {
					$tmpString .= '"' . strtr ( $key, "\"", "\\\"" ) . '"=>' . $value . ',' . "\r\n";
				} else {
					$tmpString .= '"' . strtr ( $key, "\"", "\\\"" ) . '"=>"' . strtr ( $value, "\"", "\\\"" ) . '",' . "\r\n";
				}
			}
			$tmpString = "array(\r\n" . $tmpString . ")\r\n";
			return $tmpString;
		} else
			return false;
	}
	static function __template_functions($parameters = array()) {
		foreach ( $parameters as $key => $value ) {
			if ($key === 'class') {
				$class = $value;
			} elseif ($key === 'function') {
				$function = $value;
			} else {
				$tmpParameters[ $key ] = $value;
			}
		}
		if ($function) {
			if ($class) {
				if (is_object ( $class )) {
					return call_user_func_array ( array (
						$class, 
						$function 
					), $tmpParameters );
				} else {
					$newClass = new $class ( );
					return call_user_func_array ( array (
						$newClass, 
						$function 
					), $tmpParameters );
				}
			} else {
				return call_user_func_array ( $function, $tmpParameters );
			}
		} else
			return false;
	}
	
	static function __htmlspecialchars($string) {
		if (is_array ( $string )) {
			foreach ( $string as $key => $val ) {
				$string[ $key ] = self::__htmlspecialchars ( $val );
			}
		} else {
			$string = preg_replace ( '/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1', strtr ( $string, array (
				'&' => '&amp;', 
				'"' => '&quot;', 
				'<' => '&lt;', 
				'>' => '&gt;' 
			) ) );
		
		}
		return $string;
	}
	static function __htmlencode_textarea($string) {
		if (is_array ( $string )) {
			foreach ( $string as $key => $val ) {
				$string[ $key ] = self::__htmlencode_textarea ( $val );
			}
		} else {
			$string = preg_replace ( '/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1', strtr ( $string, array (
				'&' => '&amp;', 
				'"' => '&quot;', 
				'<' => '&lt;', 
				'>' => '&gt;',
				"\n" => '<br>' 
			) ) );
		
		}
		return $string;
	}	
	static function __cycle($values, &$t) {
		list ( $var1, $var2 ) = explode ( ",", $values );
		$var1 = trim ( $var1 );
		$var2 = trim ( $var2 );
		if (! $t) {
			$t = $var1;
		} elseif ($t == $var1) {
			$t = $var2;
		} else {
			$t = $var1;
		}
		return $t;
	}
	static function __varscompiler($expr) {
		if (strstr ( $expr, "." )) {
			$vars = explode ( ".", $expr );
			$return = '';
			foreach ( $vars as $id => $key ) {
				if ($id == 0)
					$return .= $key;
				else
					$return .= '[' . $key . ']';
			}
			return $return;
		} else {
			return str_replace ( '\\', '', $expr );
		}
	}
	static function __stripvtags($expr, $statement = null) {
		$expr = preg_replace ( "/\<\?php\s+echo\s+(\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\[\]\"\'\$\x7f-\xff]*); \?\>/s", "\\1", $expr );
		if ($statement)
			$statement = strtr ( $statement, array (
				'\"' => '"' 
			) );
		$expr = strtr ( $expr, array (
			'\"' => '"' 
		) );
		return $expr . $statement;
	}
	
	private function __mkdir($dir) {
		if (file_exists ( $dir ))
			return true;
		$u = umask ( 0 );
		$r = @mkdir ( $dir, 0777 );
		umask ( $u );
		return $r;
	}
	private function __mkdirs($dir, $rootpath = '.') {
		if (! $rootpath)
			return false;
		if ($rootpath == '.')
			$rootpath = realpath ( $rootpath );
		$forlder = explode ( '/', $dir );
		$path = '';
		for($i = 0; $i < count ( $forlder ); $i ++) {
			if ($current_dir = trim ( $forlder[ $i ] )) {
				if ($current_dir == '.')
					continue;
				$path .= '/' . $current_dir;
				if ($current_dir == '..') {
					continue;
				}
				if (file_exists ( $rootpath . $path )) {
					@chmod ( $rootpath . $path, 0777 );
				} else {
					if (! $this->__mkdir ( $rootpath . $path )) {
						return false;
					}
				}
			}
		}
		return true;
	}
}
?>