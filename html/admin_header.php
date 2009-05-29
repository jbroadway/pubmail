<html>
<head>
	<title>PubMail - Mailing list admin</title>
	<link rel="stylesheet" type="text/css" href="../html/admin.css" />
	<link rel="stylesheet" type="text/css" media="all" href="../html/colorbox/colorbox.css" />
	<link rel="stylesheet" type="text/css" media="all" href="../html/colorbox/colorbox-custom.css" />
	<link rel="shortcut icon" href="../html/favicon.ico" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="../html/colorbox/jquery.colorbox-min.js"></script>
	<script type="text/javascript" src="../html/jquery.pager.js"></script>
	<script type="text/javascript">
		$(document).ready (function () {
			$('a[rel*=colorbox]').colorbox ({iframe:true, fixedWidth: 600, fixedHeight: 400, bgOpacity: 0.5});
			$('table.list').pager ('tbody', {
				navId: 'nav'
			});
		});
	</script>
</head>
<body>
<div id="wrapper">

<h1 id="title">PubMail</h1>

<div id="content">
