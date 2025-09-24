<?php
if (isset($_POST['image'])) {
    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    // PHP-variabele met de foto
    $photoVariable = $data;

    // Optioneel: bestand opslaan
    file_put_contents('uploads/foto.png', $photoVariable);

    echo "Foto ontvangen en opgeslagen";
}
?>
