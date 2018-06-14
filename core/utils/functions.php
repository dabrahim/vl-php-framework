<?php
	/*function render ( $template, $data = null ) {
		require '/core/sections.php';

		$templateDirs = array( './templates' );
		foreach ( $sections as $section ) {
			$templateDirs[] = './src/'.$section.'/templates';
		}

		require_once '/vendor/autoload.php';

		if ($data == null){
			$data = array();
		}

		$loader = new Twig_Loader_Filesystem( $templateDirs );
		$twig = new Twig_Environment( $loader );

		$data['rootDir'] = dirname($_SERVER['PHP_SELF']);
		
		echo $twig->render( $template, $data );
	}*/

	function createPattern ( $str ) {
		return '#^'.preg_replace('({:})', '([a-zA-Z0-9]+)', $str).'$#';
	}

    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for($i=0; $i<$length; $i++) {
            $str .= $keyspace[rand(0, $max)];
        }
        return $str;
    }