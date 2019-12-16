<?php

// Etape 1 : config database
$DB_HOST = "localhost";
$DB_NAME = "tinder";
$DB_USER = "root";
$DB_PASSWORD = "root";

// Etape 2 : Connexion to database
try {
    $db = new PDO("mysql:host=$DB_HOST; dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
} catch (PDOException $e) {
    print "Erreur!: " . $e->getMessage() . "<br>";
    die();
}

// Config des données POST
$email = $_POST["email"];
$pseudo = $_POST["pseudo"];
$password = $_POST["password"];
$password2 = $_POST["password2"];
$redirect = false;

// Impression des données POST (à retirer pour la version de production)
echo "email: " . $email . "<br>" . "pseudo: " . $pseudo . "<br>" . "mot de passe: " . $password . "<br>" . "mot de passe (vérification): " . $password2 . "<br>" ;


// Avant d'insérer en base de données faire les vérifications suivantes
// Ajouter un champ email [✅]
// Vérifier si le pseudo ou le mot de passe est vide [✅]
if ( empty( $email ) || empty( $pseudo ) || empty( $password ) ) {
    echo "Vous avez oublié de rentrer des informations."; // (message à retransmettre sur register.php)
    $redirect = true;
}

// Ajouter un input confirm password et vérifier si les deux sont égaux [✅]
if ( "$password" !== "$password2" ) {
    echo "Les deux mots de passe rentrés sont différents, veuillez rééssayer."; // (message à retransmettre sur register.php)
    $redirect = true;
}

// On redirige l'utilisateur si la variable $redirect est positive, sinon, on continue
if ( "$redirect" ) {
    header("Location: ../register.php");
}

// Etape 3 : prepare request
$req = $db->prepare("INSERT INTO users (email, pseudo, password) VALUES(:email, :pseudo, :password)");
$req->bindParam(":email", $email);
$req->bindParam(":pseudo", $pseudo);
$req->bindParam(":password", $password);
$req->execute();

?>