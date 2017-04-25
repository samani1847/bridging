<?php 
	$ConsId = '14722';
	$SecretKey = '1vK6C593CE';
	$Url = 'http://172.166.113.8:8080/WSLokalRest/Sep/Sep/updtglplg';
	$NoSEP = '1101R02409160000008';
	$TglPulang = '1101R024';
	$NoPPK = '2016-09-10';
	
	
	// Computes the timestamp
        date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));      
        $signature = hash_hmac('sha256', $ConsId."&".$tStamp, $SecretKey, true); 
      
        $encodedSignature = base64_encode($signature);
		
	       
    $curl = curl_init();
  
    $arrheader =  array(
         'X-cons-id: '.$ConsId,
         'X-timestamp: '.$tStamp,
         'X-signature: '.$encodedSignature        
      );  

	$xml = '<request>  
			<data>  
				<t_sep>
					<noSep>'.$NoSEP.'</noSep>
					<tglPlg>>'.$TglPulang.'</tglPlg>
					<ppkPelayanan>'.$NoPPK.'</ppkPelayanan>				
				</t_sep>
			</data>
		</request>';
  
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $Url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $arrheader);	
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

	$result = curl_exec($curl);
	curl_close($curl);
	echo $result;
	//$response->write($result);
	//return $response;
?>