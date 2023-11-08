<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $firstName = $data['firstName'];
  $lastName = $data['lastName'];
  $email = $data['email'];

  $host = 'localhost';
  $dbname = 'votre_base_de_données';
  $username = 'votre_utilisateur_mysql';
  $password = 'votre_mot_de_passe_mysql';

  $conn = new mysqli($host, $username, $password, $dbname);


  $stmt = $conn->prepare("INSERT INTO etudiants (first_name, last_name, email) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $firstName, $lastName, $email);

  if ($stmt->execute()) {
    echo json_encode(['message' => 'Étudiant enregistré avec succès']);
  } else {
    echo json_encode(['error' => 'Erreur lors de l\'enregistrement de l\'étudiant']);
  }

  $stmt->close();
  $conn->close();
} else {
  header("HTTP/1.1 405 Method Not Allowed");
}
