<? include ("item-inc.php"); ?>

<html>
<head>
<title><? echo $page_title; ?></title>
</head>
<body>

<div style="border-style: solid; border-width: 1; background-color: #FFFFCC">
  <h3 style="margin-top: 3; margin-bottom: 3; text-align:center" align="center"><b>
  <font face="Trebuchet MS" size="4">
<? echo $page_title; ?>
  </font></b></h3>
</div>
<p><? echo $page_postdate; ?></p>

<!-- <p><strong><? echo $page_summary; ?></strong></p> -->

<p>

<? echo $page_content; ?>

</p>
<p><? echo $page_link; ?></p>

<? echo($page_file); ?>

</body>
</html>
