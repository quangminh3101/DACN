<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lưu trữ file</title>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<link rel="stylesheet" href="/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" href="/vendor/css/mdb.min.css">
	<link rel="stylesheet" href="/vendor/css/addons/datatables.min.css">

	<link rel="stylesheet" href="/vendor/css/style.css">

	<script type="text/javascript" src="/vendor/js/jquery.min.js"></script>
	<script type="text/javascript" src="/vendor/js/popper.min.js"></script>
	<script type="text/javascript" src="/vendor/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/vendor/js/mdb.min.js"></script>
	<script type="text/javascript" src="/vendor/js/addons/datatables.min.js"></script>
	<script type="text/javascript" src="/vendor/js/main.js"></script>
	<script type="text/javascript" src="/vendor/js/msgBox.js"></script>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="message-modal" id="message-modal"></div>

	<?php include __DIR__."/../".$fileName.".php"; ?>
</body>
</html>