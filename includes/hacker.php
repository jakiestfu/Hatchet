<?PHP

class Hacker {
	
	private $config;
	
	function __construct(){
		$this->config = array(
			'endpoint' => 'http://news.ycombinator.com',
			'url' => 'http://lab.jakiestfu.com/hatchet/'
		);
	}
	
	function _innerHTML($element) { 
	    $innerHTML = "";
	    $children = $element->childNodes; 
	    foreach ($children as $child) 
	    { 
	        $tmp_dom = new DOMDocument();
			$tmp_dom->substituteEntities = false;
			$tmp_dom->resolveExternals = false;
	        $tmp_dom->appendChild($tmp_dom->importNode($child, true)); 
	        $innerHTML.=trim( iconv('UTF-8', 'ISO-8859-1', $tmp_dom->saveHTML()) ); 
	    } 
	    return $innerHTML; 
	}
	
	function feed(){
		return isset($_GET['feed']) ? $_GET['feed'] : 'popular';
	}
	
	function get($path=''){
		
		if($path=="popular"){
			$path = '';
		} elseif($path=="new"){
			$path = 'newest';
		} else {
			$path = '';
		}
		
		$dom = new DOMDocument();
		$dom->resolveExternals = false;
		$dom->substituteEntities = false;

		$htmlData = file_get_contents($this->config['endpoint'].'/'.$path);
		
		return json_encode($htmlData);
	}
	
	function comments($id){
		
		$final = array();
		$dom = new DOMDocument();
		$dom->resolveExternals = false;
		$dom->substituteEntities = false;
		
		@$dom->loadHTMLFile($this->config['endpoint'].'/item?id='.$id);
		
		$tables = $dom->getElementsByTagName('table');
		foreach($tables as $table){
			$final[] = $this->_innerHTML($table);
		}
		// Third Table
		return ($final[2]) . ($final[3]);
	}
	
	function home_url($path=''){
		return $this->config['url'].$path;
	}
	
}

if(isset($_GET['feed']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	$hacker = new Hacker();
	$feedData = $hacker->get($_GET['feed']);
	
	echo stripslashes($feedData);
}
