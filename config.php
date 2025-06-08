
<?php
  $conn = mysqli_connect("localhost","root","","portofelul_inteligent");  //  user: root, fara parola!
  // Conectare reusita?
  if (mysqli_connect_errno()) {
     die("Conectare la MySQL nereusita: " . mysqli_connect_error());
  };
  // Impun setul de caractere utf8
  mysqli_set_charset($conn,"utf8");
?>