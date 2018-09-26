<link rel="stylesheet" type="text/css" href="views/categorie.css" media="screen">
<script src="js/wysibb.local"></script>
    <script src="js/wysibb.local2"></script>
    <link rel="stylesheet" href="CSS/wbbtheme.css" />
    <script src="js/jquery.wysibb.min.js"></script>
    <script>
        $(function() {
            var optionWbb = {
                buttons: "bold,|,italic,|,underline,|,img,|,link"
            }
    $("#wysibb").wysibb(optionWbb);
        })
    </script>

<br /><br /><br /><br /><br /><br /><br />
<form method="POST">
   <table align="center" class="forum">
       <?php if(isset($terror)) { ?>
      <tr>
         <td colspan="2" align="center"><?= $terror ?></td>
      </tr>
      <?php } ?>
      <tr>
         <th colspan="2">Nouveau Topic</th>
      </tr>
      <tr>
         <td>Sujet</td>
         <td><input type="text" name="tsujet" size="70" maxlength="70" /></td>
      </tr>
      <tr>
         <td>Categorie</td>
         <td>
            <?= $categorie ?>
         </td>
      </tr>
      <tr>
         <td>Sous-Categorie</td>
         <td>
           <?= $souscategorie ?>
         </td>
      </tr>
      <tr>
         <td>Message</td>
         <td><textarea rows="10" cols="100" name="tcontenu" id="wysibb" class="edittext"></textarea></td>
      </tr>
      <tr>
         <td>Me notifier des reponses par mail</td>
         <td><input type="checkbox" name="tmail" /></td>
      </tr>
      <tr>
         <td colspan="2" align="center"><input type="submit" name="tsubmit" value="Poster le Topic" /></td>
      </tr>
      
   </table>
</form>
<html>
