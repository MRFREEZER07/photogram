<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="MR_FREEZER">

	<title>Login to Photogram</title>

	<!-- Bootstrap core CSS -->

	<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- JS has to be loaded in footer not header as it impacts page load time. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
	<link rel = "stylesheet" href = "../assets/dist/css/bootstrap.min.css"/>    


	<?if (file_exists($_SERVER['DOCUMENT_ROOT'].'/css/'.basename($_SERVER['PHP_SELF'], ".php").".css")) {?>
	<link
		href="css/<?=basename($_SERVER['PHP_SELF'], ".php")?>.css"
		rel="stylesheet">
	<?}?>

</head>