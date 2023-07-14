<?php
// demarre la session et stocke les données
session_start();
include 'csrf_token.php';

// Générer le token si il n'existe pas encore
if (!isset($_SESSION['token'])) {
    $token = CreateToken();
} else {
    $token = $_SESSION['token'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="Comiti">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<title>Calculez le prix de votre Abonnement à l'année</title>
<style>
  body{background: #00d2ff;  
  background: -webkit-linear-gradient(to right, #3a7bd5, #00d2ff);  
  background: linear-gradient(to right, #3a7bd5, #00d2ff); /* Background Gradient */
  }
  .container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  }
  .border {
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  padding: 20px;
  background-color: white;
  }
</style>
<script>/* Limiter pour Input*/
  function adherentsLength(input, maxLength) {
    if (input.value.length > maxLength) {
      input.value = input.value.slice(0, maxLength);
  }
  }
  function sectionLength(input, maxLength) {
    if (input.value.length > maxLength) {
      input.value = input.value.slice(0, maxLength);
  }
  }
</script>
</head>
<body>
  <div class="container">
    <div class="border">
      <div class="text-center mb-4">
        <h1>Calculez le prix de votre Abonnement à l'année</h1>
      </div>
      <form method="POST" action="calcul.php">
        <!-- genere le token dans l'input de facon caché -->
        <input type="hidden" name="token" value="<?php echo $token; ?>">
    
        <div class="form-group">
            <label for="adherents">Votre nombre d'adhérents</label>
            <input type="text" class="form-control" pattern="\d+" oninput="adherentsLength(this, 7)" name="adherents" required />
            <small class="form-text text-muted">Entrez uniquement des chiffres.</small>
        </div>
        <div class="form-group">
            <label for="sections">Le nombre de sections que vous proposez :</label>
            <input type="text" class="form-control" pattern="\d+" oninput="sectionLength(this, 4)" name="sections" required />
            <small class="form-text text-muted">Entrez uniquement des chiffres.</small>
        </div>
        <div class="form-group">
            <label for="federation">La fédération à laquelle vous êtes affiliés :</label>
            <select class="form-control" name="federation" required>
                <option value="Natation">Natation</option>
                <option value="Gymnastique">Gymnastique</option>
                <option value="Basketball">Basketball</option>
                <option value="Autre">Autre fédération</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Calcul</button>
    </form>
    </div>
  </div>
</body>
</html>
