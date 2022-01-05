<?php
include 'randomNameGenerator.php';

echo "Kode Reff: ";
$kodereff =trim(fgets(STDIN));
$linkreff = "https://www.benzinga.com/zing?mu=".$kodereff;
login:
function randomAngka($length)
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

function randomHuruf($length)
{
    $str        = "";
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

$namalengkap = randomHuruf(10).''.randomAngka(3);

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


$data = 'email='.$namalengkap.'%40dikitin.com&mu='.$kodereff.'&no-bad-guys='.$welp.'&pid='.$pid;

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
goto login;
?>