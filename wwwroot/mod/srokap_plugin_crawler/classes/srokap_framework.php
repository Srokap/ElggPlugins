<?php
class srokap_framework {
	static function init() {
		//TODO implement
	}
	
	/**
	 * @param string $url
	 * @throws IOException
	 * @return array with two items, content and metadata
	 */
	static function http_get($url) {
		$context = stream_context_create(array(
			'http' => array(
				'method' => 'GET',
				'max_redirects' => '0',
				'ignore_errors' => '0',
			)
		));
		$stream = fopen($url, 'r', false, $context);
		if ($stream===false) {
			throw new IOException("Unable to open URL via stream context wrapper: ".$url);
		}
		
		$content = stream_get_contents($stream);
		$meta = stream_get_meta_data($stream);
		fclose($stream);
		
		return array(
			$content,
			$meta,
		);
	}
	
	/**
	 * Executes system command when possible
	 * @param string $cmd
	 * @param int $return_code
	 */
	static function system_command($cmd, &$return_code) {
		
		$proc = proc_open($cmd, array(
			0 => array('pipe', 'r'),// stdin
			1 => array('pipe', 'w'),// stdout
			2 => array('pipe', 'w'),// stderr
		), $pipes);
		
		if ($proc===false) {
			throw new IOException("Error while calling proc_open");
		}
		
		$output = stream_get_contents($pipes[1]).' '.stream_get_contents($pipes[2]);
		
		$return_code = proc_close($proc);
		
		return $output;
	}
}