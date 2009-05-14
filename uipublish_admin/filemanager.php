<?php
// $Id: filemanager.php,v 1.4 2003/05/21 22:39:34 chavan Exp $
/* QTOFileManager 1.0
*
*Copyright (C) 2001 Quentin O'Sullivan <quentin@qto.com> All rights reserved.
*Web Site: http://www.qto.com/fm
*
*This program is free software; you can redistribute it and/or
*modify it under the terms of the GNU General Public License
*as published by the Free Software Foundation; either version 2
*of the License, or (at your option) any later version.
*
*This program is distributed in the hope that it will be useful,
*but WITHOUT ANY WARRANTY; without even the implied warranty of
*MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*GNU General Public License for more details.
*
*You should have received a copy of the GNU General Public License
*along with this program; if not, write to the Free Software
*Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
************************************************************************
*/

// set these configuration variables
$user = "username";  // change this to the username you would like to use. leave it empty if you dont want to use authentication
$pass = "password"; 
$MaxFileSize = "1000000"; // max file size in bytes
$HDDSpace = "100000000"; // max total size of all files in directory
$HiddenFiles = array(".htaccess","fileicon.gif","foldericon.gif","arrowicon.gif","_vti_cnf"); // add any file names to this array which should remain invisible
$FileExtsAllowed = array("htm","html","txt","gif","jpg","jpeg","pdf"); // add the extentions of file types allowed to be uploaded
$EditOn = 1; // make this = 0 if you dont want the to use the edit function at all
$EditExtensions = array("htm","html","txt","phtml","shtml","php","pl","cgi","perl"); // add the extensions of file types that you would like to be able to edit
$MakeDirOn = 1; // make this = 0 if you dont want to be able to make directories
$upload_dir = "/home/www/files/"; // Set the directory to which files will be uploaded (trailing slash needed)
$dir_url    = "/files/"; // Set the URL to the upload directory (training slash required)
$dir_url_display    = "";       // Do not show the url 
//$dir_url_display    = $dir_url; // Display the URL 
/********************************************************************/


// Include standard UIPublish header unless we're editing a file.
if ($edit)
{
  $wysiwyg = "true";
} else {
  $wysiwyg = "";
}

 include ("inc/top.php");

$ThisFileName = basename(__FILE__); // get the file name

// $path = str_replace($ThisFileName,"",__FILE__);   // get the directory path
//
// Instead of using the path in which the this script resides
// (commented line above), use the directory specified in the
// configuration section.
$path = $upload_dir;

if($login)
{
	if(!($u == $user && $password == $pass))
	{
		$msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>The login details were incorrect</font><br><br>";
		$loginfailed = 1;
	}
}

if($back)
{
	$pathext = substr($pathext, 0, -1);
	$slashpos = strrpos($pathext, "/");
	if($slashpos == 0)
	{
		$pathext = "";	
	}
	else
	{
		$pathext = substr($pathext, 0, ($slashpos+1));
	}
}


if(($user == $u || $user == "") && $edit) // if an edit link was clicked
{
	$fp = fopen($path.$pathext.$edit, "r");
	$oldcontent = fread($fp, filesize($path.$pathext.$edit));
	fclose($fp);
	
$filemanager = <<<content
	<center>
	<table width="100%" border="0" cellspacing="0" cellpadding="20" bgcolor="#eeeeee">
	<tr>
	<td>
	<font face="Verdana, Arial, Hevetica" size="4" color="#333333"><b>FILE MANAGER</b></font><br>
	<form name="form1" method="post" action="$PHP_SELF">
          <center>
            <textarea name="content" cols="143" rows="30">$oldcontent</textarea>
            <br>
  	<br>
            <input type="submit" name="save" value="Save">
            <input type="submit" name="cancel" value="Cancel">
			<input type="hidden" name="u" value="$u">
			<input type="hidden" name="savefile" value="$edit">
			<input type="hidden" name="pathext" value="$pathext">
          </center>
	</form>
	</td>
	</tr>
	</table>
	</center>
content;
	
}
elseif(($user == $u || $user == "") && !$loginfailed)
{
		
	if($save) // if the save button was pressed on the edit screen
	{
		$content = stripslashes($content);
		$fp = fopen($path.$pathext.$savefile, "w");
		fwrite($fp, $content);
		fclose($fp);
	}

	$HDDTotal = dirsize($path); // get the total size of all files in the directory including any sub directorys

	if ($upload) // if the upload button was pressed
	{
		if($HTTP_POST_FILES['uploadedfile']['name']) // if a file was actually uploaded 
		{
			//get file extension
			$HTTP_POST_FILES['uploadedfile']['name'] = str_replace("%","",$HTTP_POST_FILES['uploadedfile']['name']);  // remove any % signs from the file name
			//check if file extension is allowed
			$FileAllowed = 0;
			foreach($FileExtsAllowed as $FileExtension) 
			{
				$filename = explode(".", $HTTP_POST_FILES['uploadedfile']['name']);
				if($filename[1] == $FileExtension) 
				{
					$FileAllowed = 1;
					break;
				}	
			}
			//if the file type is allowed
			if($FileAllowed) 
			{		
				// if the file size is within allowed limits
				if($HTTP_POST_FILES['uploadedfile']['size'] > 0 && $HTTP_POST_FILES['uploadedfile']['size'] < $MaxFileSize)
				{
					// if adding the file will not exceed the maximum allowed total
					if(($HDDTotal + $HTTP_POST_FILES['uploadedfile']['size']) < $HDDSpace)
					{
						// put the file in the directory
						move_uploaded_file($HTTP_POST_FILES['uploadedfile']['tmp_name'], $path.$pathext.$HTTP_POST_FILES['uploadedfile']['name']);	
					}
					else
					{
				 		$msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>There is not enough free space and the file could<br>not be uploaded.</font><br>";
					}
				}
				else
				{
					$MaxKB = $MaxFileSize/1000; // show the max file size in Kb
					$msg =  "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'><strong><br>The file was greater than the maximum allowed<br>file size of $MaxKB Kb and could not be uploaded.<strong></font><br><br>";
				}
			}
			else
			{
			$msg =  "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'><br><strong>This file type is not allowed.</strong></font><br><br>";
			}
		}
		else
		{
			$msg =  "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>Please press the browse button and select a file<br>to upload before you press the upload button.</font><br>";
		}
	}
	elseif($delete) // if the delete button was pressed
	{
		// delete the file or directory
		if(is_dir($path.$pathext.$delete))
		{
			$result = @rmdir($path.$pathext.$delete);
			if($result == 0)
			{
				$msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>The folder could not be deleted. The folder must be<br>empty before you can delete it. You also may<br>not be authorised to delete this folder.</font><br>";
			}
		}
		else
		{
			unlink($path.$pathext.$delete);
		}
	}
	elseif($mkdir && $MakeDirOn)
	{
		$result = @mkdir($path.$pathext.$dirname, 0700);
		if($result == 0)
		{
			$msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>The folder could not be created. Make sure the name you<br>entered is a valid folder name.</font><br>";
		}
	}

	$HDDTotal = dirsize($path); // get the total size of all files in the directory including any sub directorys
	$freespace = ($HDDSpace - $HDDTotal)/1000; // work out how much free space is left
	$HDDTotal = (int) ($HDDTotal/1000); // convert to Kb instead of bytes and type cast it as an int
	$freespace = (int) $freespace; // type cast as an int
	$HDDSpace = (int) ($HDDSpace/1000); // convert to Kb instead of bytes and type cast it as an int
	$MaxFileSizeKb = (int) ($MaxFileSize/1000); // convert to Kb instead of bytes and type cast it as an int

	// if $MakeDirOn has been set to on show some html for making directories
	if($MakeDirOn)
	{
		$mkdirhtml = "<input type=\"text\" name=\"dirname\" size=\"15\"><input type=\"submit\" name=\"mkdir\" value=\"Make Directory\">";
	}
	
	// build the html that makes up the file manager
	// the $filemanager variable holds the first part of the html
	// including the form tags and the top 2 heading rows of the table which
	// dont display files
	$filemanager = <<<content
	<center>
	<table width="100%" border='0' cellspacing='0' cellpadding='20' bgcolor='#eeeeee'>
	<tr>
	<td>
	<font face="Verdana, Arial, Hevetica" size="4" color="#333333"><b>FILE MANAGER</b></font><br>
	$msg
	<font face="Verdana, Arial, Hevetica" size="2"><b>Total Space:</b> $HDDSpace Kb     <b>Max File Size:</b> $MaxFileSizeKb Kb</font><br>
	<font face="Verdana, Arial, Hevetica" size="2"><b>Free Space:</b> $freespace Kb     <b>Used Space:</b> $HDDTotal Kb</font><br>
	<form name="form1" method="post" action="$PHP_SELF" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="$MaxFileSize">
  	$mkdirhtml <br><input type="file" name="uploadedfile">
  	<input type="submit" name="upload" value="Upload">
  	<input type="hidden" name="u" value="$u">
	<input type="hidden" name="pathext" value="$pathext">
	
	</form>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr> 
	<td width="20" height="20" bgcolor="#333333"></td>
	<td bgcolor="#333333" height="20"><font face="Verdana, Arial, Helvetica" size="2" color="#FFFFFF"><b>&nbsp;FILENAME&nbsp;</b></font></td>
	<td height="20" bgcolor="#333333"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica"><b>&nbsp;SIZE (bytes)&nbsp;</b></font></td>
	<td height="20" bgcolor="#333333"></td>
	<td height="20" bgcolor="#333333"></td>
	</tr>
	<tr> 
	<td height="2" bgcolor="#999999"></td>
	<td height="2" bgcolor="#999999"></td>
	<td height="2" bgcolor="#999999"></td>
	<td height="2" bgcolor="#999999"></td>
	<td height="2" bgcolor="#999999"></td>
	</tr>
content;

// if the current directory is a sub directory show a back link to get back to the previous directory
if($pathext)
{
	$filemanager  .= <<<content
					<tr>
					<td bgcolor="#ffffff"><center><img border="0" src="FolderUp.gif" width="16" height="16"></center></td>
					<td>&nbsp;<a href="$PHP_SELF?u=$u&back=1&pathext=$pathext"><font face="Verdana, Arial, Helvetica" size="2" color="#666666">&laquo;BACK</font></a>&nbsp;</td>
					<td bgcolor="#ffffff"></td>
					<td></td>
					<td bgcolor="#ffffff"></td>
					</tr>
					<tr> 
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					</tr>	
content;
}

	// build the table rows which contain the file information
	$newpath = substr($path.$pathext, 0, -1);   // remove the forward or backwards slash from the path
	$dir = @opendir($newpath); // open the directory
	while($file = readdir($dir)) // loop once for each name in the directory
	{
		// if the name is not a directory and the name is not the name of this program file
		if($file != "." && $file != ".." && $file != "$ThisFileName")
		{
			$match = 0;
			foreach($HiddenFiles as $name) // for each value in the hidden files array
			{
				if($file == $name) // check the name is not the same as the hidden file name
				{	
					$match = 1;	 // set a flag if this name is supposed to be hidden
				}
			}	
			if(!$match) // if there were no matches the file should not be hidden
			{	
					$filedata = stat($path.$pathext.$file); // get some info about the file
					
					// find out if the file is one that can be edited
					$editlink = 	"";
					if($EditOn && !is_dir($path.$pathext.$file))  // if the edit function is turned on and the file is not a directory
					{
						$dotpos = strrpos($file, ".");
						foreach($EditExtensions as $editext)
						{
							$ext = substr($file, ($dotpos+1));
							if(strcmp($ext, $editext) == 0)
							{
								$editlink = 	"&nbsp;<a href='$PHP_SELF?edit=$file&u=$u&pathext=$pathext'><font face='Verdana, Arial, Helvetica' size='2' color='#666666'>EDIT</font></a>&nbsp;";
							}
						}
					}
					
					// create some html for a link to delete files 
					$deletelink = "<a href=\"$PHP_SELF?delete=$file&u=$u&pathext=$pathext\"><font face=\"Verdana, Arial, Helvetica\" size=\"2\" color=\"#666666\">DELETE</font></a>";
					
					// if it is a directory change the file name to a directory link
					if(is_dir($path.$pathext.$file))
					{
						$hrefname = "<a href=\"$PHP_SELF?u=$u&pathext=$pathext$file/\"><font color=\"#666666\">$file</font></a>";
						$fileicon = "<center><img border=\"0\" src=\"Folder.gif\" width=\"16\" height=\"16\"></center>";
						if(!$MakeDirOn)
						{
							$deletelink = "";
						}
					}
					else
					{
						$hrefname = "<a href=\"$dir_url$pathext$file\">$dir_url_display$file</a>";
						$fileicon = "<center><img border=\"0\" src=\"File.gif\" width=\"20\" height=\"22\"></center>";
					}
					
					// append 2 table rows to the $content1 variable, the first row has the file
					// informtation, the 2nd row makes a black line 1 pixel high
					$content1 .= <<<content
					<tr>
					<td bgcolor="#ffffff">$fileicon</td>
					<td>&nbsp;<font face="Verdana, Arial, Helvetica" size="2"> 
					$hrefname
          </font>&nbsp;</td>
					<td bgcolor="#ffffff">&nbsp;<font face="Verdana, Arial, Helvetica" size="2">$filedata[7]</font>&nbsp;</td>
					<td>&nbsp;$deletelink&nbsp;</td>
					<td bgcolor="#ffffff">&nbsp;$editlink&nbsp;</td>
					</tr>
					<tr> 
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					<td height="1" bgcolor="#000000"></td>
					</tr>	
content;
			}
		}
	}
	closedir($dir); // now that all the rows have been built close the directory
	$content1 .= "</td></tr></table></table></center>"; // add some closing tags to the $content1 variable
	$filemanager  .= $content1; // append the html to the $filemanager variable

}
else 
// login screen
{
	$filemanager = <<<content
	<center>
	<table border="0" cellspacing="0" cellpadding="20" bgcolor="#eeeeee">
	<tr>
	<td>
	<font face="Verdana, Arial, Hevetica" size="4" color="#333333"><b>FILE MANAGER</b></font><br>
	<form name="form1" method="post" action="$PHP_SELF">
	$msg
	<center>
	<font face="Verdana, Arial, Hevetica" size="2">User Name:</font><input type="text" name="u"><br>
  	<font face="Verdana, Arial, Hevetica" size="2">Password:</font><input type="password" name="password"><br>
  	<input type="submit" name="login" value="Login">
  	</center>
	</form>
	</td>
	</tr>
	</table>
	</center>
content;
}

function dirsize($dir) 
// calculate the size of files in $dir
{
	$dh = opendir($dir);
	$size = 0;
	while (($file = readdir($dh)) !== false)
	{
		if ($file != "." and $file != "..") 
		{
			$path = $dir."/".$file;
			if (is_dir($path))
			{
				$size += dirsize("$path/");
			}
			elseif (is_file($path))
			{
				$size += filesize($path);
			}
}
	}
	closedir($dh);
	return $size;
}

?>


<html>
<head>
</head>
<body>
<?php echo $filemanager ?>
</body>
</html>
