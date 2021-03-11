<?php
if( isset( $_POST['refid'] ) ){
    $refid = $_POST['refid'];
}else{
    $refid = 0;
}

/* بجای 1000 مبلغ پرداختی خود را قرار دهید، به تومان */
$Amount = 1000; // toman

/* توکن دریافتی از سایت payping.ir | بجای Token توکن خود را قرار دهید. */
$TokenCode = "Token";
$data = array(
    'amount' => $Amount,
    'refId'  => $refid
);
try{
    $curl = curl_init();
    curl_setopt_array( $curl, array(
        CURLOPT_URL => "https://api.payping.ir/v2/pay/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 45,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer " . $TokenCode,
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ) );
    $response = curl_exec( $curl );
    $err = curl_error( $curl );
    $header = curl_getinfo( $curl );
    curl_close( $curl );
    if($err){
        $msg = 'خطا در ارتباط به پی‌پینگ :شرح خطا' . $err;
    }else{
        if($header['http_code'] == 200){
            $response = json_decode( $response, true );
            if( isset($refid) and $refid != '' ){
                $msg = ' تراکنش موفق بود: ' . $refid;
                $outp['msg'] = $msg;
            }else{
                $msg = 'متافسانه سامانه قادر به دریافت کد پیگیری نمی‌باشد! نتیجه درخواست: ' . $header['http_code'];
            }
        }elseif($header['http_code'] == 400){
            $msg = ' تراکنش ناموفق بود، شرح خطا: ' . $response;
            $outp['msg'] = $msg;
        }else{
            $msg = ' تراکنش ناموفق بود، شرح خطا: ' . $header['http_code'];
        }
    }
}catch( Exception $e ){
    $msg = ' تراکنش ناموفق بود، شرح خطا سمت برنامه شما: ' . $e->getMessage();
} ?>
<!DOCTYPE html>
<html>
<head>
	<title>وضعیت پرداخت درگاه پرداخت پی‌پینگ</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		*{
			box-sizing: border-box;
		}
		body{
			font-family: tahoma;
			font-size: 14px;
			direction: rtl;
		}
		.alert{
			width: 320px;
			font-family: tahoma;
			margin: auto;
			background-color: #172b4d;
			color: #fff;
			line-height: 2;
			text-align: justify;
			padding: 15px;
		}
	</style>
</head>
<body>
	<div class="alert">
		<?php echo $msg; ?>
	</div>
</body>
</html>