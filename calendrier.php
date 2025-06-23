<!-- 2eme VERSION : Capture rendu en PDF-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
async function exportCalendarsToPDF() {
    const spinner = document.getElementById('spinner');
    const calendars = document.querySelectorAll('.calendrier');

    if (!spinner || calendars.length === 0) {
        alert('Aucun calendrier trouvé.');
        return;
    }

    spinner.style.display = 'block';

    try {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('l', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();

        for (let i = 0; i < calendars.length; i++) {
            const calendar = calendars[i];

            try {
                const canvas = await html2canvas(calendar, { scale: 2 });
                const imgData = canvas.toDataURL('image/jpeg', 1.0);

                const ratio = Math.min(pageWidth / canvas.width, pageHeight / canvas.height);
                const imgWidth = canvas.width * ratio;
                const imgHeight = canvas.height * ratio;
                const x = (pageWidth - imgWidth) / 2;
                const y = (pageHeight - imgHeight) / 2;

                if (i !== 0) pdf.addPage();
                pdf.addImage(imgData, 'JPEG', x, y, imgWidth, imgHeight, '', 'FAST');
            } catch (err) {
                console.error(`Erreur lors de la capture du calendrier ${i + 1} :`, err);
            }
        }

        pdf.save("calendrier.pdf");
    } catch (err) {
        console.error("Erreur lors de la génération du PDF :", err);
        alert("Une erreur est survenue lors de l'exportation du PDF.");
    } finally {
        spinner.style.display = 'none';
    }
}
</script>


<?php
$db = new PDO('mysql:host=localhost;port=3308;dbname=formation', 'user', '');

// Récupérer paramètres GET
$formationId = isset($_GET['formation']) ? intval($_GET['formation']) : null;
$startYear = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Charger la formation
$selectedFormation = null;
if ($formationId) {
    $stmt = $db->prepare("SELECT * FROM formations WHERE id = ?");
    $stmt->execute([$formationId]);
    $selectedFormation = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Calendrier <?= $startYear ?> - <?= $startYear + 2 ?></title>
    <style>
        <?php include 'styleCalendrier.css'; ?>
    </style>
</head>

<body>
    <h1>Calendrier de <?= $startYear ?> à <?= $startYear + 2  ?></h1>
    <header class="navbar">
        <div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#year<?= $startYear ?>"><?= $startYear ?></a></li>
                <li><a href="#year<?= $startYear + 1 ?>"><?= $startYear + 1 ?></a></li>
                <li><a href="#year<?= $startYear + 2 ?>"><?= $startYear + 2 ?></a></li>
                <li><a href="#download">Télécharger</a></li>
            </ul>
        </div>
    </header>

    <div class="calendar-container">
        <?php
            include 'function_optimize.php';
            for ($year = $startYear; $year <= $startYear +2; $year++) {
                generateCalendarAnnuaire($year, $selectedFormation);
            }
        ?>
    </div>
    <input class="javaScript" type="button" id="download" onclick="exportCalendarsToPDF()" value="Exporter en PDF"/>

    <div id="spinner" class="spinner"> Génération du PDF en cours...</div>

    <footer class="copyright">&copy; 2025 MARTIN Robin </footer>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const cells = document.querySelectorAll(".annuaire td");

    cells.forEach(cell => {
        cell.addEventListener("click", function () {
            const row = this.parentElement;
            const cellsInRow = [...row.children];
            const index = cellsInRow.indexOf(this);

            const startIndex = index - (index % 3);

            // Vérifier si les 3 cellules sont déjà sélectionnées
            const isSelected = cellsInRow
                .slice(startIndex, startIndex + 3)
                .every(cell => cell.classList.contains("selected-day"));

            if (isSelected) {
                // Désélectionner les 3 cellules
                cellsInRow.slice(startIndex, startIndex + 3)
                    .forEach(cell => cell.classList.remove("selected-day"));
            } else {
                // Sélectionner les 3 cellules
                cellsInRow.slice(startIndex, startIndex + 3)
                    .forEach(cell => cell.classList.add("selected-day"));
            }
        });
    });
});
</script>

</body>
</html>

