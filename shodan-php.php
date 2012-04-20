<?php

class WebAPI {

	/*	PHP Wrapper around the SHODAN webservices API  
		Author of PHP Wrapper: jordan-wright (jmwright798 at gmail.com)
		
		SHODAN Database designed and maintained by achillean (John Matherly)
		SHODAN website: http://www.shodanhq.com
		Follow achillean on twitter: http://twitter.com/#!/achillean
	*/

	private $key;
	private $base;
	
	/* Constructor - Instantiates WebAPI object
	   Example: $shodan = new WebAPI("your API key"); 
	*/
	function __construct($api_key) {
		$this->key = $api_key;
		$this->base = "http://www.shodanhq.com/api/";
	}
	
	/* General CURL Request function
	   Arguments:	function - function to be performed (Example: "search")
			params - Associative array of arguments to that function

	   Returns: Associative array of JSON decoded output from the SHODAN webservice
	*/
	function _request($function,$params) {
		$params = array("key" => $this->key) + $params;
		$url = $this->base . "$function?" . http_build_query($params);
		$req = curl_init($url);
		curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($req);
		curl_close($req);
		return json_decode($ret, true);
		
	}

	/* Search Function
	   Arguments:	query - Query to be searched for

	   Returns: Result (associative array) from SHODAN webservices
	*/
	function search($query)
	{
		return $this->_request("search",array("q"=>$query));
	}

	
	/* Exploit DB Download Function
	   Arguments:	id - Exploit DB ID of wanted exploit
	   Returns: Result (associative array) from SHODAN webservices
	*/
	function exploitdb_download($id)
	{
		return $this->_request("exploitdb/download",array("id"=>$id));
	}

	/* Exploit DB Search Function
	   Arguments:	query - Query to be searched for
			args - Associative array of other arguments to better define query
	   
	   Returns: Result (associative array) from SHODAN webservices
	*/
	function exploitdb_search($query, $args)
	{
		$args = array("q"=>$query)+$args;
		return $this->_request("exploitdb/search",$args);
	}

	/* Host Search Function
	   Arguments:	ip - IP Address of specified host(s)
	   
	   Returns: Result (associative array) from SHODAN webservices
	*/
 	function host($ip)
	{
		return $this->_request("host",array("ip"=>$ip));
	}

	/* Fingerprint Function
	   Arguments:	banner - HTTP Banner
 
	   Returns: Result (associative array) from SHODAN webservices
	*/
	function fingerprint($banner)
	{
		return $this->_request("fingerprint",array("banner"=>$banner));
	}

	/* Locations Function
	   Arguments:	query - Query to be searched for

	   Returns: Result (associative array) from SHODAN webservices
	*/
	function locations($query)
	{
		return $this->_request("locations",array("q"=>$query));
	}

	/* MSF Download Function
	   Arguments: id - fullname of Metasploit Module  
	   
	   Returns: Result (associative array) from SHODAN webservices
	*/
	function msf_download($id)
	{
		return $this->_request("msf/download",array("id"=>$id));
	}

	/* MSF Search Function
	   Arguments: query - Metasploit module to be searched for

	   Returns: Result (associative array) from SHODAN webservices
	*/
	function msf_search($query, $args)
	{
		$args = array("q"=>$query) + $args;
		return $this->_request("msf/search",$args);
	}
}
?>
