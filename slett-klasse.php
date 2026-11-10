<?php  /* slett-klasse */
/*
/*  Programmet lager et skjema for å velge en klasse som skal slettes
/*  Programmet sletter den valgte klassen
*/
?>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema">
  Klassekode
  <select name="klassekode" id="klassekode" required>
    <option value="">Velg klasse</option>
    <?php
      include("db-tilkobling.php");
      $sqlSetning="SELECT * FROM klasse;";
      $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
      $antallRader=mysqli_num_rows($sqlResultat);

      for ($r=1;$r<=$antallRader;$r++)
        {
          $rad=mysqli_fetch_array($sqlResultat);
          $klassekode=$rad["klassekode"];
          $klassenavn=$rad["klassenavn"];
          print ("<option value='$klassekode'>$klassekode - $klassenavn</option>");
        }
    ?>
  </select><br />
  <input type="submit" value="Slett klasse" name="slettKlasseKnapp" id="slettKlasseKnapp" />
</form>

<?php
  if (isset($_POST ["slettKlasseKnapp"]))
    {
      $klassekode=$_POST ["klassekode"];

      include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

      $sqlSetning="SELECT * FROM klasse WHERE klassekode='$klassekode';";
      $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
      $antallRader=mysqli_num_rows($sqlResultat);

      if ($antallRader==0)  /* klassen er ikke registrert */
        {
          print ("Klassen finnes ikke");
        }
      else
        {
          $sqlSetning="SELECT * FROM student WHERE klassekode='$klassekode';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallStudenter=mysqli_num_rows($sqlResultat);

          if ($antallStudenter!=0)
            {
              print ("Klassen kan ikke slettes fordi det finnes studenter i klassen. Slett studentene f&oslash;rst.");
            }
          else
            {
              $sqlSetning="DELETE FROM klasse WHERE klassekode='$klassekode';";
              mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; slette data i databasen");
                /* SQL-setning sendt til database-serveren */

              print ("F&oslash;lgende klasse er n&aring; slettet: $klassekode <br />");
            }
        }
    }
?>
