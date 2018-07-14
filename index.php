<?php require_once('lib/SOAPtest.php'); ?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
</head>

<body>

	<div id="lock"></div>

	<div id="header">

		<span id="title">SOAPtest</span>

        <div id="controls">
            <input type="text" id="controls-url" placeholder="URL" />
            <input type="button" value="Send" id="soap-send"/>
            <input type="button" value="Clear" id="soap-clear"/>
        </div>

	</div>

	<div id="wrapper">

        <div id="request" class="window window-left">
            <textarea id="request-content" class="envelope-content"></textarea>
        </div>

        <div id="response" class="window window-right">
            <textarea id="response-content" class="envelope-content" readonly></textarea>
        </div>

    </div>

	<div id="footer">
		<a href="http://pokojowczyk.pl" class="link" target="_blank">pokojowczyk.pl</a>
	</div>

</body>

<script src="js/main.js"></script>

</html>
