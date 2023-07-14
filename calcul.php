<?php
// Session ouverte pour recuperer le token
session_start();
include 'csrf_token.php';

// Récupérer le token dans l'input
$TokenGet = filter_input(INPUT_POST, 'token');

// Vérifier la validité du token, si il n'est pas bon il redirige vers une page erreur
if (!ValideToken($TokenGet)) {
    header("Location: erreur.php?message=" . urlencode("Token CSRF invalide."));
    exit();
}

function Prix($nbAdherents, $nbSections, $federation) {
    try {
        // Adhérents
        $prixAdherents = 0;
        // prix selon nombres d'adhérents
        if ($nbAdherents <= 100) {
            $prixAdherents = 10 * 12;
        } elseif ($nbAdherents <= 200) {
            $prixAdherents = $nbAdherents * 0.10 * 12;
        } elseif ($nbAdherents <= 500) {
            $prixAdherents = $nbAdherents * 0.09 * 12;
        } elseif ($nbAdherents <= 1000) {
            $prixAdherents = $nbAdherents * 0.08 * 12;
        } elseif ($nbAdherents >= 10000) {
            $prixAdherents = 1000 * 12;
        } else {
            $tranches = intval($nbAdherents / 1000); // utilisation de intval pour avoir un entier
            $prixAdherents = $tranches * 70 * 12;
        }

        // Section
        $prixSections = 0;
        // Mois en cours
        $moisActuel = intval(date("n"));
        // Prix de la section selon le mois en cours avec une boucle   
        for ($i = 1; $i <= $nbSections; $i++) {
            if ($i % $moisActuel === 0) {
                $prixSections += 3 * 12;
            } else {
                $prixSections += 5 * 12;
            }
        }

        // Avantage
        $avantage = 0;
        // Si il y a plus de 1000 adhérents
        if ($nbAdherents > 1000) {
            $prixSections -= 5 * 12;
        }
        // avantage selon la fédération    
        if ($federation === "Natation") {
            $avantage = (3 * 5) * 12;
        } elseif ($federation === "Gymnastique") {
            if ($nbAdherents > 100) {
                $avantage = $prixAdherents * 0.15;
            }
        } elseif ($federation === "Basketball") {
            $avantage = $prixSections * 0.3;
        }

        // Tva
        $prixTVA = 1.2;
        // Calcul du prix HT
        if ($federation === "Natation" or $federation === "Basketball") {
            $prixHT = $prixAdherents + max($prixSections - $avantage, 0);
        } elseif ($federation === "Gymnastique") {
            $prixHT = $prixSections + $prixAdherents - $avantage;
        } else {
            $prixHT = $prixAdherents + $prixSections;
        }

        // Prix TTC
        $prixTTC = $prixHT * $prixTVA;
        $prixTTCFormater = number_format($prixTTC, 2);
        // Prix Mensuel
        $prixMensuel = $prixTTC / 12;
        $prixMensuelFormater = number_format($prixMensuel, 2);

        // Stock les valeurs dans un tableau
        return array($prixAdherents, $prixSections, $avantage, $prixTTCFormater, $prixTVA, $prixMensuelFormater);
    } catch (Exception $e) {
        throw $e;
    }
}

try {
    if (isset($_POST['adherents'], $_POST['sections'], $_POST['federation'])) {
        $nbAdherents = filter_input(INPUT_POST, 'adherents', FILTER_VALIDATE_INT);
        $nbSections = filter_input(INPUT_POST, 'sections', FILTER_VALIDATE_INT);
        $federation = filter_input(INPUT_POST, 'federation');

        // Appel de la fonction Prix()
        list($prixAdherents, $prixSections, $avantage, $prixTTCFormater, $prixTva, $prixMensuelFormater) = Prix($nbAdherents, $nbSections, $federation);
    } else {
        throw new Exception("Données manquantes.");
    }
} catch (Exception $e) {
    header("Location: erreur.php?message=" . urlencode($e->getMessage()));
    exit();
}
//Supprime les données de la sessions
session_unset();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<style>
    body {
    background: #00d2ff;  
    background: -webkit-linear-gradient(to right, #3a7bd5, #00d2ff);  
    background: linear-gradient(to right, #3a7bd5, #00d2ff); /* Background Gradient */
    }
    .border {
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    padding: 20px;
    background-color: white;
    }
    .border-table {
    background-color: white;}
</style>
<title>Votre Devis</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4" style="text-align: center;">Voici la formule qui vous est proposée</h1>
    <div class="border">
        <table class="table table-striped border-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
                <tbody>
                    <?php 
                        echo "<tr>
                        <td>Prix Adhérents</td>
                        <td>$nbAdherents</td>
                        <td>$prixAdherents €</td>
                        </tr>
                    
                        <tr>
                        <td>Prix Sections</td>
                        <td>$nbSections</td>
                        <td>$prixSections €</td>
                        </tr>
                    
                        <tr>
                        <td>Avantage</td>
                        <td></td>
                        <td>$avantage €</td>
                        </tr>
                    
                        <tr>
                        <td>Prix TVA</td>
                        <td> </td>
                        <td>$prixTva &#37;</td>
                        </tr>
                    
                        <tr>
                        <td>Prix TTC</td>
                        <td> </td>
                        <td>$prixTTCFormater €</td>
                        </tr>
                    
                        </tbody>
                    
                        </table>
                    
                        <br/>
                    
                        <h5>Le montant de votre offre personnalisée est de $prixTTCFormater €, soit $prixMensuelFormater € par mois.</h5>";
                    ?>
                </tbody>
        </table>
    </div>
    </div>
</body>
</html>
