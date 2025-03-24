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
            <button class="add">Ajouter une FAQ</button>

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
                                    <!-- Boutons pour modifier et supprimer -->
                                    <a href="modifier_faq.php?id=<?php echo $faq['id']; ?>" class="edit">Modifier</a>
                                    <a href="supprimer_faq.php?id=<?php echo $faq['id']; ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
