<?php
require 'db.php';
require 'Slim/Slim.php';


$app = new Slim();


$app->get('/', 'Depan');
$app->get('/coba', 'test');
$app->post('/test', 'test');
$app->post('/BuatKlaimBaru', 'BuatKlaimBaru');
$app->post('/HapusKlaim', 'HapusKlaim');
$app->post('/IsiDataKlaim', 'IsiDataKlaim');
$app->post('/AmbilDataKlaim', 'AmbilDataKlaim');
$app->post('/Grouper1', 'Grouper1');
$app->post('/Grouper2', 'Grouper2');
$app->post('/FinalKlaim', 'FinalKlaim');
$app->post('/KirimOnline', 'KirimOnline');
$app->post('/EditFinal', 'EditFinal');


$app->run();


/* METHOD GET DISINI */
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function Depan() {
  echo "Halaman Depan";
}

function BuatKlaimBaru($request, $response, $args) {	
	
	$json = '{
   "metadata":{
      "method":"new_claim"
   },
   "data":{
      "nomor_kartu":"'.$request->getParsedBody()['nokartu'].'",
      "nomor_sep":"'.$request->getParsedBody()['nosep'].'",
      "nomor_rm":"'.$request->getParsedBody()['norm'].'",
      "nama_pasien":"'.$request->getParsedBody()['namapasien'].'",
      "tgl_lahir":"'.$request->getParsedBody()['tgllahir'].'",
      "gender":"'.$request->getParsedBody()['jeniskelamin'].'"
	}}';



	$json = mc_encrypt ($json, getKey());

	$ch = curl_init(getUrlWS());	

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);

    $result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	


	$response->write($result);	
	return $response;	
}

function HapusKlaim($request, $response, $args) {	
	
	$json = '{
   "metadata":{
      "method":"delete_claim"
   },
   "data":{
      "nomor_sep":"'.$request->getParsedBody()['nosep'].'",
      "coder_nik":"'.getCoderNik().'"
	}}';



	$json = mc_encrypt ($json, getKey());

	$ch = curl_init(getUrlWS());	

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);

    $result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	


	$response->write($result);	
	return $response;	
}


function IsiDataKlaim($request, $response, $args) {	
	$nosep = $request->getParsedBody()['nosep'];
	$nokartu = $request->getParsedBody()['nokartu'];
	$tgl_masuk=$request->getParsedBody()['tgl_masuk'];
	$tgl_pulang=$request->getParsedBody()['tgl_pulang'];
	$jenis_rawat=$request->getParsedBody()['jenis_rawat'];
	$kelas_rawat=$request->getParsedBody()['kelas_rawat'];
	$adl_sub_acute=$request->getParsedBody()['adl_sub_acute'];
	$adl_chronic=$request->getParsedBody()['adl_chronic'];
	$icu_indicator=$request->getParsedBody()['icu_indicator']; 
	$icu_los=$request->getParsedBody()['icu_los']; 
	$ventilator_hour=$request->getParsedBody()['ventilator_hour']; 
	$upgrade_class_ind=$request->getParsedBody()['upgrade_class_ind']; 
	$upgrade_class_class=$request->getParsedBody()['upgrade_class_class']; 
	$upgrade_class_los=$request->getParsedBody()['upgrade_class_los']; 
	$birth_weight=$request->getParsedBody()['birth_weight']; 
	$discharge_status=$request->getParsedBody()['discharge_status']; 
	$diagnosa=$request->getParsedBody()['diagnosa']; 
	$procedure=$request->getParsedBody()['procedure']; 
	$tarif_rs=$request->getParsedBody()['tarif_rs']; 
	$tarif_poli_eks=$request->getParsedBody()['tarif_poli_eks']; 
	$nama_dokter=$request->getParsedBody()['nama_dokter']; 
	// $kode_tarif=$request->getParsedBody()['kode_tarif']; 
	$payor_id=$request->getParsedBody()['payor_id']; 
	$payor_cd=$request->getParsedBody()['payor_cd']; 
	// $coder_nik=$request->getParsedBody()['coder_nik']; 
	
	
	
	$json = '{
   "metadata":{
      "method":"set_claim_data",
      "nomor_sep":"'.$nosep.'"
   },
   "data":{
      "nomor_sep":"'.$nosep.'",
      "nomor_kartu":"'.$nokartu.'",
      "tgl_masuk":"'.$tgl_masuk.'",
      "tgl_pulang":"'.$tgl_pulang.'",
      "jenis_rawat":"'.$jenis_rawat.'",
      "kelas_rawat":"'.$kelas_rawat.'",
      "adl_sub_acute":"'.$adl_sub_acute.'",
      "adl_chronic":"'.$adl_chronic.'",
      "icu_indikator":"'.$icu_indicator.'",
      "icu_los":"'.$icu_los.'",
      "ventilator_hour":"'.$ventilator_hour.'",
      "upgrade_class_ind":"'.$upgrade_class_ind.'",
      "upgrade_class_class":"'.$upgrade_class_class.'",
      "upgrade_class_los":"'.$upgrade_class_los.'",
      "birth_weight":"'.$birth_weight.'",
      "discharge_status":"'.$discharge_status.'",
      "diagnosa":"'.$diagnosa.'",
      "procedure":"'.$procedure.'",
      "tarif_rs":"'.$tarif_rs.'",
      "tarif_poli_eks":"'.$tarif_poli_eks.'",
      "nama_dokter":"'.$nama_dokter.'",
      "kode_tarif":"'.getKodeTarif().'",
      "payor_id":"'.$payor_id.'",
      "payor_cd":"'.$payor_cd.'",
      "coder_nik":"'.getCoderNik().'"
   }
}';
   //print_r($json);
	$json = mc_encrypt ($json, getKey());
	$ch = curl_init(getUrlWS());	

    curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);			


	

	$result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	

	return $response;
}

function Grouper1($request, $response, $args) {	
	$special_cmg_list = '';
	$nosep = $request->getParsedBody()['nosep'];
	$json = '{
   "metadata":{
      "method":"grouper",
      "stage":"1"
   },
   "data":{
      "nomor_sep":"'.$nosep.'"
   }
}';   
    
	
	$json = mc_encrypt ($json, getKey());
	$ch = curl_init(getUrlWS());

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);

    $hasil = substr ($result, 29, strlen ($result));
	$hasil = substr ($hasil, 0,-28); 
	$resultDec = mc_decrypt (getKey(), $hasil); 
    $result = $resultDec;
    

	$decode = json_decode($result, true);
	//print_r($decode);
	if (!array_key_exists('special_cmg_option', $decode)){
		$status = array('special_cmg'=>'false');		
	}else{
		$status = array('special_cmg'=>'true');
	}
	
	if (!array_key_exists('sub_acute', $decode)){
		$status1 = array('sub_acute'=>'false');		
	}else{
		$status1 = array('sub_acute'=>'true');
	}
	
	if (!array_key_exists('chronic', $decode)){
		$status2 = array('chronic'=>'false');		
	}else{
		$status2 = array('chronic'=>'true');
	}
	
	$arr1 = array_merge ($status1, $status2);
	$arr2 = array_merge($arr1, $status);
	$data = json_decode ($result, true);
	$result = array_merge($data, $arr2);
	$response->write(json_encode($result));

	return $response;	
}

function Grouper2($request, $response, $args) {		
	$nosep = $request->getParsedBody()['nosep'];
	$Specialcmg = $request->getParsedBody()['special_cmg'];
	
	$json = '{
   "metadata":{
      "method":"grouper",
      "stage":"2"
   },
   "data":{
      "nomor_sep":"'.$nosep.'",
      "special_cmg":"'.$Specialcmg.'"
   }}';
   
    
   	$json = mc_encrypt ($json, getKey());
	$ch = curl_init(getUrlWS());

	

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);
	$result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	
	return $response;
}

function FinalKlaim($request, $response, $args) {	
	$nosep = $request->getParsedBody()['nosep'];
	// $coder_nik= $request->getParsedBody()['coder_nik'];
	
	$json = '{  
   "metadata":{  
      "method":"claim_final"
   },
   "data":{  
      "nomor_sep":"'.$nosep.'",
      "coder_nik":"'.getCoderNik().'"
   }
}';
	$json = mc_encrypt ($json, getKey());
	$ch = curl_init(getUrlWS());
	

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);
	//$response->write($result);
	$result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
   // $response->write($result);	
    


   $json = '{
	 "metadata": {
 	 "method":"send_claim_individual"
 	},
 	"data": {
 	"nomor_sep":"'.$nosep.'"
 	}
	}';


	$json = mc_encrypt ($json, getKey());
	$ch = curl_init(getUrlWS());
	

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);
	$result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	
	return $response;	
}

function KirimOnline($request, $response, $args) {	
	$nosep = $request->getParsedBody()['nosep'];

$json = '{
 "metadata": {
 "method":"send_claim_individual"
 },
 "data": {
 "nomor_sep":"'.$nosep.'"
 }
}';


	$json = mc_encrypt ($json, getKey());
	$ch = curl_init(getUrlWS());
   

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);
	$result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	
	return $response;	
}






function EditFinal($request, $response, $args) {	
	$nosep = $request->getParsedBody()['nosep'];	
	
	$json = '{
			"metadata": {
			"method":"reedit_claim"
			},
			"data": {
			"nomor_sep":"' .$nosep.'"
			}
		}';
		
   
    
	$json = mc_encrypt ($json, getKey());
	$ch = curl_init(getUrlWS());
	

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);
	$result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	
}

function AmbilDataKlaim($request, $response, $args) {	


	$json = '{
 "metadata": {
 "method":"pull_claim"
 },
 "data": {
 "start_dt":"'.$request->getParsedBody()['stat_dt'].'",
 "stop_dt":"'.$request->getParsedBody()['stop_dt'].'",
 "jenis_rawat":"'.$request->getParsedBody()['jenis'].'"
 }
}';
	
	$json = mc_encrypt ($json, getKey());

	$ch = curl_init(getUrlWS());	
	

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);


    if ($request->getParsedBody()['krip'] == 'true') {
	$result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	$result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	$result = mc_decrypt (getKey(), $result);			    
    $response->write($result);	
	}else{$response->write($result);}
	return $response;	
}



function mc_encrypt($data, $key) {
$key = hex2bin($key);
if (mb_strlen($key, "8bit") !== 32) {
throw new Exception("Needs a 256-bit key!");

}
$iv_size = openssl_cipher_iv_length("aes-256-cbc");

$iv = openssl_random_pseudo_bytes($iv_size);
$encrypted = openssl_encrypt($data,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv );

$signature = mb_substr(hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit");
$encoded = chunk_split(base64_encode($signature.$iv.$encrypted));
return $encoded;
}

function mc_decrypt($strkey, $str) {
$key = hex2bin($strkey);

///	check key length, must be 256 bit or 32 bytes 
if (mb_strlen($key, "8bit") !== 32) {
throw new Exception("Needs a 256-bit key!");
}


$iv_size = openssl_cipher_iv_length("aes-256-cbc");
$decoded = base64_decode($str);
$signature = mb_substr($decoded,0,10,"8bit"); 
$iv = mb_substr($decoded,10,$iv_size,"8bit");
$encrypted = mb_substr($decoded,$iv_size+10,NULL,"8bit");
$calc_signature = mb_substr(hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit");
if(!mc_compare($signature,$calc_signature)) {
return "SIGNATURE_NOT_MATCH"; /// signature doesn't match
}

$decrypted = openssl_decrypt($encrypted,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv);
return $decrypted;
}

///	Compare function 
function mc_compare($a, $b) {

///	compare individually to prevent timing attacks

///	compare length

if (strlen($a) !== strlen($b)) return false;

///	compare individual 
$result = 0;

for($i = 0; $i < strlen($a); $i ++) { $result |= ord($a[$i]) ^ ord($b[$i]);
}

return $result == 0;
}

function Cari_Special_Prosthesis($array, $field, $value)
{
   foreach($array as $key => $array)
   {
      if ( $array[$field] === $value )
         return $key;
   }
   return false;
}

?>
