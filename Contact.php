<?php
// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Verzamel de gegevens van het formulier
  $naam = strip_tags(trim($_POST["naam"]));
  $naam = str_replace(array("\r","\n"),array(" "," "),$naam);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $bericht = trim($_POST["bericht"]);

  // Controleer of alle velden zijn ingevuld
  if (empty($naam) || empty($bericht) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Vul alstublieft alle verplichte velden in en probeer het opnieuw.";
    exit;
  }

  // Ontvangend e-mailadres
  $ontvanger = "info@fonteyn.nl";

  // Onderwerp van de e-mail
  $onderwerp = "Nieuw bericht van $naam";

  // E-mailinhoud
  $inhoud = "Naam: $naam\n";
  $inhoud .= "E-mailadres: $email\n\n";
  $inhoud .= "Bericht:\n$bericht\n";

  // Extra headers
  $headers = "Van: $naam <$email>";

  // Probeer de e-mail te verzenden
  if (mail($ontvanger, $onderwerp, $inhoud, $headers)) {
    http_response_code(200);
    echo "Bedankt! Uw bericht is verzonden.";
  } else {
    http_response_code(500);
    echo "Er is iets fout gegaan en uw bericht kon niet worden verzonden. Probeer het later opnieuw.";
  }

} else {
  http_response_code(403);
  echo "Er is een probleem met uw inzending. Probeer het later opnieuw.";
}
?>
