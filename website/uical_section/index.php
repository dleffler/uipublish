<? // $Id: index.php,v 1.1 2003/04/15 03:03:21 chavan Exp $ ?>
<? include ("list-inc.php"); ?>

<html>

<head>
<title>Events at Website</title>
<link rel="alternate" type="application/rss+xml" title="Website Events Feed" href="http://www.website.com/events/rss.php" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<script type="text/javascript">
    var GB_ROOT_DIR = "/apps/greybox/";
</script>
<script type="text/javascript" src="/apps/greybox/AJS.js"></script>
<script type="text/javascript" src="/apps/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="/apps/greybox/gb_scripts.js"></script>
<link href="/apps/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div style="border-style: solid; border-width: 1; background-color: #FFFFCC">
  <h3 style="margin-top: 3; margin-bottom: 3; text-align:center" align="center">
  <b><font face="Trebuchet MS" size="4">Events at Website</font></b></h3>
</div>
<h3>Upcoming Events:</h3>
<p><font size="2"><? echo $page_list_cal; ?> </font></p>
<a title="RSS feed" style="COLOR: #fff; BACKGROUND-COLOR: #f60" href="http://www.website.com/events/rss.php">
<font size="2">RSS 2.0</font></a>
</font></font>
<p></p>
<p><a href="pastevents.php">Past Events</a></p>

</body>

</html>
