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

function BuatKlaimBaru() {
	$app = global $app;
		
	echo $app->request()->post();
	// $json = '{
 //   "metadata":{
 //      "method":"new_claim"
 //   },
 //   "data":{
 //      "nomor_kartu":"'.$app->request()->post('nokartu').'",
 //      "nomor_sep":"'.$app->request()->post('nosep').'",
 //      "nomor_rm":"'.$app->request()->post('norm').'",
 //      "nama_pasien":"'.$app->request()->post('namapasien').'",
 //      "tgl_lahir":"'.$app->request()->post('tgllahir').'",
 //      "gender":"'.$app->request()->post('jeniskelamin').'"
	// }}';



	// $json = mc_encrypt ($json, getKey());

	// $ch = curl_init(getUrlWS());	

	// curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// $result = curl_exec($ch);
	// curl_close($ch);

 //    $result = str_replace ('----BEGIN ENCRYPTED DATA----', '', $result);
	// $result = str_replace ('----END ENCRYPTED DATA----', '', $result);
	// $result = mc_decrypt (getKey(), $result);			    
	// $response = $app->response();
 //    $response->write($result);	


	// $response->write($result);	
	// return $response;	
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
