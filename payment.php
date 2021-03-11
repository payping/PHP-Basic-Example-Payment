<?php
/* دریافت مبلغ از فرم ساخته شده. */
$amount = intval( $_POST['Amount'] );

/* clientRefId: در صورت استفاده در حالت غیر دمو بهتر است شماره فاکتور در نظر گرفته شود. */
if( isset( $_POST['clientRefId'] ) ){
    $clientRefId = $_POST['clientRefId'];
}else{
    $clientRefId = "example@gmail.com";
}

/* payerIdentity: شماره موبایل باشد، در غیر اینصورت ایمیل استفاده شود. */
if( isset( $_POST['Mobile'] ) ){
	$payerIdentity = $_POST['Mobile'];
}elseif( isset( $_POST['clientRefId'] ) ){
	$payerIdentity = $_POST['clientRefId'];
}else{
	$payerIdentity = time();
}

if( isset( $_POST['Description']) ){
    $desc = $_POST['Description'];
}else{
    $desc = '';
}

/* توکن دریافتی از سایت payping.ir | بجای Token توکن خود را قرار دهید. */
$TokenCode = "Token";

/* آدرس صفحه برگشت کاربر بعد از صفحه پرداخت | بجای domain.com آدرس سایت خود را قرار دهید. */
$returnUrl = "htps://domain.com/payping/PHP-Basic-API/verify.php";

$data = array(
    'clientRefId'   => $clientRefId,
    'payerIdentity' => $payerIdentity,
    'Amount'        => $amount,
    'Description'   => $desc,
    'returnUrl'     => $returnUrl
);

try{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.payping.ir/v2/pay",
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
            "content-type: application/json"
        ),
            )
    );
    $response = curl_exec( $curl );


    $header = curl_getinfo( $curl );
    $err = curl_error( $curl );
    curl_close( $curl );

    if( $err ){
        $msg = 'کد خطا: CURL#' . $er;
        $erro = 'در اتصال به درگاه مشکلی پیش آمد.';
        return false;
    }else{
        if( $header['http_code'] == 200 ){
            $response = json_decode( $response, true );
            if( isset( $response ) and $response != '' ){
                $response = $response['code'];
				/* ارسال به درگاه پرداخت با استفاده از کد ارجاع */
				$GoToIPG = 'https://api.payping.ir/v2/pay/gotoipg/' . $response;
                header( 'Location: ' . $GoToIPG );
            }else{
                $msg = 'تراکنش ناموفق بود - شرح خطا: عدم وجود کد ارجاع';
            }
        }elseif($header['http_code'] == 400){
            $msg = 'تراکنش ناموفق بود، شرح خطا: ' . $response;
        }else{
            $msg = 'تراکنش ناموفق بود، شرح خطا: ' . $header['http_code'];
        }
    }
}catch(Exception $e){
    $msg = 'تراکنش ناموفق بود، شرح خطا سمت برنامه شما: ' . $e->getMessage();
}