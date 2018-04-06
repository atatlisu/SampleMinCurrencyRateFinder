<?php
// src/AppBundle/Controller/MinCurrencyRateController.php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MinCurrencyRateController
{
    /**
     * @Route("/minRates")
     */
    public function getMinimumCurrencyRates()
    {
    	$jsonURLs = array('http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0','http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3');
    	
    	$dolarValues = [];
    	$euroValues = [];
    	$gbpValues = [];
    	foreach($jsonURLs as $var){
    		$json=file_get_contents($var);
    		$obj = json_decode($json);
    		
    		if(!is_array($obj)){
    			$temp = $obj->result;

    			$tempDolar = $temp[0];
    			$tempEuro = $temp[1];
    			$tempGbp = $temp[2];

    			foreach ($tempDolar as $key => $value) {
    				if($key == 'amount'){
    					array_push($dolarValues, $value);
    				}
    			}
    			foreach ($tempEuro as $key => $value) {
    				if($key == 'amount'){
    					array_push($euroValues, $value);
    				}
    			}
    			foreach ($tempGbp as $key => $value) {
    				if($key == 'amount'){
    					array_push($gbpValues, $value);
    				}
    			}
    		}else{
    			$tempDolar = $obj[0];
    			$tempEuro = $obj[1];
    			$tempGbp = $obj[2];
    			foreach ($tempDolar as $key => $value) {
    				if($key == 'oran'){
    					array_push($dolarValues, $value);
    				}
    			}
    			foreach ($tempEuro as $key => $value) {
    				if($key == 'oran'){
    					array_push($euroValues, $value);
    				}
    			}
    			foreach ($tempGbp as $key => $value) {
    				if($key == 'oran'){
    					array_push($gbpValues, $value);
    				}
    			}
    		}
    	
	    		
    	}
		
    
    	//echo print_r($dolarValues,true);
        $minDolar =min($dolarValues);
        $minEuro  =min($euroValues);
        $minGbp   =min($gbpValues);
        return new Response(
            '<html><body>Min Dolar value is: '.$minDolar.'</br>Min Euro value is: '.$minEuro.'</br>Min Sterlin value is: '.$minGbp.'</br></body></html>'
        );
    }
}
