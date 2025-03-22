<?php
// Inclure la classe Pierre
require_once __DIR__ . '/../../config/Pierre.php';

// Créer une instance de la classe Pierre pour accéder à getFAQs
$pierreModel = new \bd\Pierre();

// Récupérer les FAQs
$faqsadmin = $pierreModel->getFAQsAdmin();
?>

<main>
    <section id="faq" class="faq-section">
        <div class="container">
            <h2 class="faq-title">Foire Aux Questions (FAQ)</h2>
            <p class="faq-subtitle">Voici quelques réponses aux questions fréquemment posées. Si vous avez d'autres questions, n'hésitez pas à nous contacter !</p>

            <?php if (empty($faqsadmin)): ?>
                <div class="faq-empty">
                    <p>Aucune question fréquemment posée n'est disponible pour le moment. N'hésitez pas à nous contacter si vous avez des questions!</p>
                </div>
            <?php else: ?>
                <?php foreach ($faqsadmin as $faq): ?>
                    <div class="faq-item">
                        <h3 class="faq-question"><?php echo htmlspecialchars($faq['question']); ?></h3>
                        <p class="faq-answer"><?php echo htmlspecialchars($faq['reponse']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>