<?php
// Inclure la classe Pierre
require_once __DIR__ . '/../../config/Pierre.php';

// Créer une instance de la classe Pierre pour accéder à getFAQs
$pierreModel = new \bd\Pierre();

// Récupérer les FAQs
$faqs = $pierreModel->getFAQs();
?>

        <div class="container">
            <h2 class="faq-title">Modifier FAQ utilisateurs</h2>
            <button class="add"  id="openModal">Ajouter une question</button>
            <!-- Modal d'ajout -->
            <div id="addModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeModal">&times;</span>
                    <h2>Ajouter une question/réponse</h2>
                    
                    <!-- Formulaire d'ajout -->
                    <form id="addStoneForm" method="POST" action="models/ajouter_faq.php">
                        <label for="question">Question :</label>
                        <input type="text" id="question" name="question" required>

                        <label for="reponse">Réponse :</label>
                        <textarea id="reponse" name="reponse" required></textarea>

                        <button type="submit" class="btn-submit">Ajouter</button>
                    </form>
                </div>
            </div>
            <p id="message" style="display:none; color: green;">Question ajoutée avec succès !</p>
            <!-- Tableaux des FAQ -->
            <table class="faq-table">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Réponse</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($faqs)): ?>
                        <tr>
                            <td colspan="3">Aucune question fréquemment posée n'est disponible pour le moment. N'hésitez pas à nous contacter si vous avez des questions!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($faqs as $faq): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($faq['question']); ?></td>
                                <td><?php echo htmlspecialchars($faq['reponse']); ?></td>
                                <td>
                                <?php $prepQestion = str_replace("'", "!", $faq['question']); ?>
                                <a href="models/supprimer_faq.php?question=<?php echo urlencode($prepQestion); ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ?');">Supprimer</a>
                                <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
