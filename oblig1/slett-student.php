
<?php  /* slett-student */
/*
/*  Programmet lager et skjema for å velge en student som skal slettes
/*  Programmet sletter den valgte studenten
*/
  include("db-tilkobling.php");

  $sqlSetning="SELECT * FROM student;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
  $antallRader=mysqli_num_rows($sqlResultat);
?>

<script src="funksjoner.js"> </script>

<h3>Slett student</h3>

<form method="post" action="" id="slettStudentSkjema" name="slettStudentSkjema" onSubmit="return bekreft()">
  Velg student
  <select name="brukernavn" id="brukernavn" required>
    <option value="">Velg student</option>
    <?php
      for ($r=1;$r<=$antallRader;$r++)
        {
          $rad=mysqli_fetch_array($sqlResultat);
          $brukernavn=$rad["brukernavn"];
          $fornavn=$rad["fornavn"];
          $etternavn=$rad["etternavn"];

          print ("<option value='$brukernavn'>$brukernavn - $fornavn $etternavn</option>");
        }
    ?>
  </select><br />

  <input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" />
</form>

<?php
  if (isset($_POST ["slettStudentKnapp"]))
    {
      $brukernavn=$_POST ["brukernavn"];

      $sqlSetning="SELECT * FROM student WHERE brukernavn='$brukernavn';";
      $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
      $antallRader=mysqli_num_rows($sqlResultat);

      if ($antallRader==0)
        {
          print ("Studenten finnes ikke");
        }
      else
        {
          $sqlSetning="DELETE FROM student WHERE brukernavn='$brukernavn';";
          mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");

          print ("F&oslash;lgende student er n&aring; slettet: $brukernavn <br />");
        }
    }
?>
