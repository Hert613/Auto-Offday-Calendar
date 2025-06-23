<?php
$db = new PDO('mysql:host=localhost;port=3308;dbname=formation', 'user', '');
    
// Récupérer toutes les formations triées par intitulé
$stmt = $db->prepare("SELECT * FROM formations ORDER BY intitule ASC");
$stmt->execute();
$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si on a reçu une formation sélectionnée en GET
$selectedFormationId = isset($_GET['formation']) ? intval($_GET['formation']) : null;

// Récupérer la formation sélectionnée si applicable
$selectedFormation = null;
if ($selectedFormationId) {
    $stmt2 = $db->prepare("SELECT * FROM formations WHERE id = :id");
    $stmt2->execute(['id' => $selectedFormationId]);
    $selectedFormation = $stmt2->fetch(PDO::FETCH_ASSOC);
}

// Définit une année par défaut si non fournie
$startYear = isset($startYear) && is_numeric($startYear) ? $startYear : date('Y');

// Exemple de données pour $formations si non défini
$selectedFormationId = $selectedFormationId ?? '';
?>
<script>
  const toggle = document.getElementById('selectedFormation');
  const menu = document.getElementById('formationList');
  const input = document.getElementById('formationInput');

  // Toggle menu
  toggle.addEventListener('click', () => {
    toggle.parentElement.classList.toggle('open');
  });

  // Select formation
  menu.addEventListener('click', (e) => {
    if (e.target.classList.contains('option')) {
      const selectedText = e.target.textContent;
      const selectedId = e.target.dataset.id;
      toggle.textContent = selectedText;
      input.value = selectedId;
      toggle.parentElement.classList.remove('open');
    }
  });

  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!toggle.parentElement.contains(e.target)) {
      toggle.parentElement.classList.remove('open');
    }
  });
</script>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Générateur de calendrier</title>
    <link rel="stylesheet" href="styleIndex.css"> <!-- Préférable à include -->
</head>
<body>
    <div class="form">
        <form method="GET" action="calendrier.php" target="_blank">
            <div class="title">Bienvenue</div>
            <div class="subtitle">Créons votre calendrier !</div>

            <div class="input-container ic1">
                <input type="number" class="input" id="year" name="year" value="<?= htmlspecialchars($startYear) ?>" min="1900" max="2100" placeholder=" ">
                <div class="cut1"></div>
                <label for="year" class="placeholder">Année de départ :</label>
            </div>

            <div class="input-container ic2">
                <select name="formation" id="formation" class= "input" required>
                    <option value="">-- Sélectionnez --</option>
                    <?php foreach ($formations as $formation): ?>
                        <option value="<?= htmlspecialchars($formation['id']) ?>" 
                            <?= ($formation['id'] == $selectedFormationId) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($formation['intitule']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="cut2"></div>
                <label for="formation" class="placeholder">Choisissez une formation :</label>
            </div>

            <button class="submit" type="submit">Générer le calendrier</button>
            <p class="copyright">&copy; 2025 MARTIN Robin</p>
        </form>
    </div>
</body>
</html>



