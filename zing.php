<?php
include 'randomNameGenerator.php';

echo "Link Reff: ";
$linkreff = trim(fgets(STDIN));
login:
function randomString($length)
{
    $str        = "";
    $characters = '1234567890';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

$passwoard = 'polos123321A';



$r = new randomNameGenerator('json');
$names = $r->generateNames(10);
$nama = json_decode($names);
$fn = $nama[0]->first_name;
$ln = $nama[0]->last_name;
$nl = $nama[0]->first_name.''.$nama[0]->last_name;
$namal = strtolower($nl);
$namalengkap = $namal.''.randomString(3);

$inbox = $namalengkap . '@dikitin.com';


	 //create email
$createmail = curl_init();
curl_setopt_array($createmail, array(
  CURLOPT_URL => 'https://generator.email/check_adres_validation3.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'usr='.$namalengkap.'&dmn=dikitin.com',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));
$rcreatemail = curl_exec($createmail);
$httpcode1 = curl_getinfo($createmail, CURLINFO_HTTP_CODE);
curl_close($createmail);
if($httpcode1 == 400){
 echo  "\n\33[37;1mGagal membuat email $inbox";
    echo "\n\n";
	}else{
		$httpcode1 == 200;
    echo  "\n\33[37;1mBerhasil membuat email $inbox";
    echo "\n";
}

//get pid
$getid = curl_init();

curl_setopt_array($getid, array(
  CURLOPT_URL => $linkreff,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$rgetid = curl_exec($getid);

curl_close($getid);
$doc = new DOMDocument();
$doc->loadHTMLFile($linkreff);
$welp = $doc->getElementById('welp')->getAttribute('value');
echo "Welp : $welp\n";

$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML($rgetid);
$tags = $dom->getElementsByTagName('input');
for($i = 0; $i < $tags->length; $i++) {
    $grab = $tags->item($i);
    if($grab->getAttribute('name') === 'pid') {
        $pid = $grab->getAttribute('value');
    }
}
echo "Pid : $pid\n";


$data = 'email='.$namalengkap.'%40dikitin.com&mu=683869&no-bad-guys='.$welp.'&pid='.$pid;

ob_start();
echo $data;
$length = ob_get_length();
ob_end_clean();
$inputreff = curl_init();

curl_setopt_array($inputreff, array(
  CURLOPT_URL => $linkreff,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $data,
  CURLOPT_HTTPHEADER => array(
    'Host: www.benzinga.com',
    'Content-Length: '.$length,
    'Cookie: _ga=GA1.2.403497006.1635442874; _gid=GA1.2.821647634.1635442874; _gat=1',
    'Origin: https://www.benzinga.com',
    'Content-Type: application/x-www-form-urlencoded',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
    'Referer: '.$linkreff,
    'Accept-Encoding: gzip, deflate',
    'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8',
    
  ),
));

$rinputreff = curl_exec($inputreff);
curl_close($inputreff);

$claim = explode('<div style="padding-top: 6px;font-weight: bold;">',$rinputreff)[1];
$claim = explode('</div>',$claim)[0];
echo "$claim\n";


$regist = curl_init();

curl_setopt_array($regist, array(
  CURLOPT_URL => 'https://accounts.benzinga.com/api/v1/account/register/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode(array(
            "first_name" => $fn." ".$ln,
            "email" => $inbox,
            "password" => "Yesbisa123",
            "confirm_password" => "Yesbisa123"
  )
  ),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
  ),
));

$rregist = curl_exec($regist);
curl_close($regist);

if($rregist == "error code: 1015"){
  echo "IP BLOCKED\n";
  $file = fopen("reff_zing_not_login.txt","a");  
  fwrite($file,"".$inbox); 
  fwrite($file,"\n"); 
  fclose($file);  
  exit;
}else{
  echo "LOGIN SUCCESS\n";
  $file = fopen("reff_zing_login.txt","a");  
  fwrite($file,"".$inbox); 
  fwrite($file,"\n"); 
  fclose($file);  
};
goto login;
?>