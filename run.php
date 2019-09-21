<?php
//created by alip dzikri
//UltraVoucher Auto Regist
//https://github.com/dziunincode69/
$test = file_get_contents('https://api.randomuser.me');
preg_match('/"first":"(.*?)",/',$test,$first);
$email = "p".$first."".rand(100,999)."@gmail.com";
$pass = "pu".rand(100,999)."mich";
$device = 'b'.rand(10,99).'e2aed'.rand(100,999).'e8ccc';
//headers
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'User-Agent: Dalvik/2.1.0 (Linux; U; Android 7.1.1; 1337 Build/HACKME)';
echo "============================== \n";
echo "AUTO REGISTER UltraVoucher \n";
echo "Created by Alip Dzikri \n";
echo "Your device id";
echo $device;
echo "\n";
echo "============================== \n";
echo "Nomor : ";
$nomor = trim(fgets(STDIN));
echo "Refferall : ";
$reff = trim(fgets(STDIN));
echo "[+]Proses register... \n";
//SET SET
$getotp = curl('https://ppm.ultravoucher.co.id/api/nov/v1/promo/member_register', '{"deviceUniqueId":"'.$device.'","username":"'.$email.'","password":"'.$pass.'","phoneNumber":"'.$nomor.'","firstName":"'.$first.'","lastName":"-","referrerCode":"'.$reff.'","isCorporateMember":-1}' , $headers);
$jsgetotp = json_decode($getotp[0]);
if($jsgetotp->status == "success"){
	echo "[+]Sukses Get OTP \n";
	echo "OTP : ";
	$otp = trim(fgets(STDIN));
	$verifotp = curl('https://ppm.ultravoucher.co.id/api/nov/v1/promo/verification', '{"username":"'.$email.'","code":"'.$otp.'"}', $headers);
	$jsverifotp = json_decode($verifotp[0]);
	if($jsverifotp->status == "success"){
		echo "[+]SUKSES VERIF OTP \n";
		echo "[+]Sukses Registss \n";
		$proseslogin = curl('https://ppm.ultravoucher.co.id/lifestyle-ws-vc/api-rest/authentication/create', '{"deviceUniqueId":"'.$device.'""username":"'.$nomor.'","password":"'.$pass.'"}', $headers);
		$jsproseslogin = json_decode($proseslogin[0]);
		print_r($jsproseslogin);
		if ($jsproseslogin->abstractResponse->responseMessage == "Authentication success"){
			echo "[+]Sukses Login \n";
			echo "created by alip dzikri \n ";
		} else {
			print_r($jsproseslogin);
		}
	} else {
		print_r($jsverifotp);
	}
} else {
	print($jsgetotp);
}
function curl($url, $fields = null, $headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($fields !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        if ($headers !== null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $result   = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return array(
            $result,
            $httpcode
        );
    }
