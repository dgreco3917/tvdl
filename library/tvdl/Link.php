<?

class Link {
	public function __construct ($url) {
		$this->url = $url;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function getFilename( $filename='' ) {
		if ( $filename ) {
			return $filename;
		}

		$url_info = parse_url($this->url);
		$path_info = pathinfo($url_info['path']);
		return $path_info['filename'];
	}
	
	public function downloadData() {
		$this->data = @file_get_contents($this->url);
		if ( ! $this->data ) {
			throw new Exception("Unable to download torrent");
		}
		return $this->data;
	}

	public function getMime() {
		$this->downloadData();
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		return $finfo->buffer($this->data);
	}
	
	public function getExtension() {
		switch ($this->getMime()) {
			case 'application/x-bittorrent':
				return ".torrent";
				break;
		}
	}
	
	public function saveToFile ( $filename='', $directory='' ) {
		$filename = $this->getFilename($filename) . $this->getExtension();
		file_put_contents( $directory . $filename, $this->downloadData());
		return $directory . $filename;
	}
	
}
