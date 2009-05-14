<? include ("list-inc.php"); ?>

<html>

<head>
<title>News from Website</title>
<link rel="alternate" type="application/rss+xml" title="Website News Feed" href="http://www.website.com/news/rss.php" />
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
  <b><font face="Trebuchet MS" size="4">News at Website</font></b></h3>
</div>
<p><font size="2"><? echo $page_list; ?> </font></p>
<a title="RSS feed" style="COLOR: #fff; BACKGROUND-COLOR: #f60" href="http://www.website.com/news/rss.php">
<font size="2">RSS 2.0</font></a>
</font></font>

</body>

</html>
