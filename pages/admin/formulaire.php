<html>
<head>
	<script type="text/javascript" language="JavaScript" src="functions.js"></script>
</head>
<body>

<br /><br /><br />
	<input type="text" id="search" />
	<br />

	<div id="result" style="BACKGROUND-COLOR:#ddd;"/>
	<script language="JavaScript" type="text/javascript">
		document.getElementById("search").onkeyup=Search;
		document.getElementById("search").onchange=Search;
		document.getElementById("search").onfocus=Focus;
		document.getElementById("search").onblur=Blur;
		
		document.getElementById("result").style.position = 'absolute';
		var res = document.getElementById("search").getBoundingClientRect();
		document.getElementById("result").style.top = res.bottom;
		document.getElementById("result").style.left = res.left;
		
		function Search()
		{
			document.getElementById("result").innerHTML="<img src='ajax-loader.gif' />";
			var text=GetURLOutput("index.php?page=action&action=search&search="+document.getElementById("search").value);

			document.getElementById("result").innerHTML=text;
		}
		function Focus()
		{
			document.getElementById("result").style.display = 'block';
		}
		function Blur()
		{
			document.getElementById("result").style.display = 'none';
		}
	</script>
</body>