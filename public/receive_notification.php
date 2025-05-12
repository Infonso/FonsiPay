<?php

use App\Domain\Entity\Payment;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../vendor/autoload.php';

$jwtSecret = 'mi_clave_secreta';

// Obtener la cabecera Signature
$headers = getallheaders();
$signature = $headers['Signature'] ?? null;

if (!$signature) {
  http_response_code(400);
  echo "Falta la cabecera Signature.";
  exit;
}

// Obtener el cuerpo JSON crudo
$rawJson = file_get_contents('php://input');

// Verificar firma
try {
  // Verificar la firma JWT
  $decoded = JWT::decode($signature, new Key($jwtSecret, 'HS256'));

  // Convertir a array para comparar
  $decodedArray = (array) $decoded;
  $data = json_decode($rawJson, true);

  // Verificar que el JWT coincida con el contenido enviado
  if ($decodedArray !== $data) {
    http_response_code(403);
    echo "Firma inválida: el contenido del JWT no coincide con el cuerpo.";
    exit;
  }

  $data['status'] = 'Received';

  // Convertir array a entidad Payment
  $payment = Payment::fromArray($data);
  // Mostrar resultado (lógica para visualización)
  echo '<div class="card p-3 mb-3">
          <h3 class="card-title">Pago recibido</h3>
          <ul class="list-group list-group-flush">';
  foreach ($payment->toArray() as $key => $value) {
    echo '<li class="list-group-item"><strong>' . $key . ':</strong>' . $value . '</li>';
  }
  echo '</ul></div>';
} catch (Exception $e) {
  http_response_code(401);
  echo "Firma inválida: " . $e->getMessage();
}
