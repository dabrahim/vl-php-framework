<?php

namespace Esmt\VLFramework;

class Request {
	private $_get;
	private $_post;
	private $_path;
	private $_files;

	public function __construct () {
		$uri = $_SERVER['REQUEST_URI'];

		// PATH
		$this->_path = parse_url( $uri, PHP_URL_PATH );

		$this->_get = $_GET;

		// PARAMETRES POST
		$this->_post = $_POST;

		//FICHIERS
        $this->_files = $_FILES;
	}

	public function sections () {
        return explode( '/', $this->relPath() );
    }

	public function post () {
		return $this->_post;
	}

	public function get () {
		return $this->_get;
	}

	public function path () {
		return $this->_path; 
	}

	public function relPath () {
		return str_replace( dirname($_SERVER['PHP_SELF'])."/" , '', $this->_path );
	}

	function type () {
		return $_SERVER['REQUEST_METHOD'];
	}

	function files () {
	    return $this->_files;
    }
}