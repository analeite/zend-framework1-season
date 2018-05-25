<?php

class Sam_Import
{


    public function __construct()
    {
    	$filepath = 'testeimport.txt';
    	$separator = ';';
    	$return = $this->import($filepath, $separator);
    	$filepath = '';
    	$separator = ';';
    	$filename = 'textexport.txt';
    	$this->export($return, $separator, $filepath, $filename);  	
    }
    
    public function Import($filepath, $separator){
    	$file = fopen("$filepath", "r");
    	while (($data = fgetcsv($file,0,$separator)) !== FALSE) {
    		$array[] = $data;
    	}
    	return $array;
    	 
    }
    
    public function export($data, $glue, $pathfile, $filename){
    	$file = fopen("$pathfile"."$filename", 'w');
    	foreach ($data as $pieces){
    		$string = implode($glue, $pieces);
    		$string.="\n";
	    	$write = fwrite($file, $string);
    	}
	    $close = fclose($file);
    	
    }


}

