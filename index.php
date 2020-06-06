<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
	<title>فرم درگاه پرداخت پی‌پینگ</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		*{
			box-sizing: border-box;
		}
		body {
			font-family: tahoma;
			font-size: 14px;
			direction: rtl;
		}
		.form-payment {
			margin: 0 auto;
			font-family: tahoma;
			text-align: center;
		}
		.form-payment form {
			width: 320px;
			font-family: tahoma;
			margin: auto;
			background-color: #172b4d;
			padding: 15px;
		}
		.form-payment form input {
			width: 100%;
			display: block;
			font-family: tahoma;
			padding: 10px;
			text-align: right;
			margin-bottom: 15px;
			border: none;
		}
		.form-payment form input[type="email"], .form-payment form input[name="Mobile"]{
			text-align: left;
			direction: ltr;
		}
		.form-payment form input[name="Amount"]{
			text-align: left;
			direction: ltr;
		}
		.form-payment form input[name="Amount"]::-webkit-input-placeholder {
		 	text-align: right;
			direction: rtl;
		}

		.form-payment form input[name="Amount"]::-moz-placeholder {
		 	text-align: right;
			direction: rtl;
		}
		.form-payment form input[type="submit"]{
			background-color: #0080ff;
			color: #fff;
			cursor: pointer;
			text-align: center;
			border: 1px solid #0080ff;
		}
		.form-payment form input[type="submit"]:hover{
			background-color: #172b4d;
		}
	</style>
</head>
<body>
	<div class="form-payment">
		<h1>فرم پرداخت آنلاین به درگاه پی‌پینگ</h1>
		<form action="payment.php" method="post">
			<input type="email" name="clientRefId" placeholder="example@gmail.com" required/>
			<input type="text" name="Mobile" placeholder="0912..."/>
			<input type="text" name="Amount" placeholder="مبلغ بین 1000 تا 50 میلیون تومان." required/>
			<input type="text" name="Description" placeholder="توضیحات" />
			<input type="submit" value="پرداخت" />
		</form>
	</div>
</body>
</html>