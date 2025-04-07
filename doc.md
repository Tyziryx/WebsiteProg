# Documentation des fonctions PHP

## Fichier : config/Users.php

### getAllUsers()
- Récupère tous les utilisateurs (table `utilisateurs`).
- Renvoie un tableau d’objets `User`.

### getUserByPseudo($pseudo)
- Sélectionne un utilisateur selon son pseudo.
- Renvoie un objet `User` ou `false` si inexistant.

### getUserByEmail($email)
- Sélectionne un utilisateur selon son email.
- Renvoie un objet `User` ou `false` si inexistant.

### ajouterUtilisateur($pseudo, $email, $password, $admin = 0)
- Insère un nouvel utilisateur dans la table `utilisateurs`.
- Renvoie `true` si l’insertion a réussi, sinon `false`.

### modifierUtilisateur($originalPseudo, $userData)
- Met à jour divers champs d’un utilisateur (hormis le pseudo).
- Renvoie `true` ou `false` selon le résultat de la requête.

### updateUser($pseudo, $newEmail, $newPassword)
- Met à jour l’email et le mot de passe de l’utilisateur.
- Renvoie `true` si la mise à jour a réussi, sinon `false`.

### updateUserEmail($pseudo, $newEmail)
- Met à jour l’email de l’utilisateur.
- Renvoie `true` si la requête aboutit, sinon `false`.

### supprimerUtilisateur($pseudo)
- Supprime l’utilisateur (équivalent à `deleteUser($pseudo)`).
- Renvoie `true` en cas de succès, sinon `false`.

### deleteUser($pseudo)
- Supprime l’utilisateur dont le pseudo est fourni.
- Renvoie `true` si au moins une ligne a été supprimée, sinon `false`.

### toggleAdmin($pseudo, $adminStatus)
- Modifie le champ `admin` (0/1) de l’utilisateur.
- Renvoie `true` ou `false` en fonction du succès.

### toggleAdminSwitch($pseudo)
- Bascule le statut admin de l’utilisateur (true ↔ false).
- Renvoie `true` en cas de succès, sinon `false`.

### isAdminStatus($pseudo)
- Vérifie si l’utilisateur est admin.
- Renvoie la valeur du champ `admin` (0 ou 1).


---

## Fichier : config/Pierre.php

### listePierre()
- Sélectionne toutes les entrées de la table `pierre`.
- Renvoie un tableau d’objets `Pierre`.

### getPierre($id)
- Récupère une pierre par son ID (table `pierre`).
- Renvoie un objet `Pierre` ou `false` si l’ID est introuvable.

### getPierreByNom($nom_pierre)
- Sélectionne une pierre par son nom (table `geodex`).
- Renvoie un objet `Pierre` ou `null` si non trouvée.

### getPierresByRarete($rarete)
- Récupère toutes les pierres de la table `geodex` ayant la rareté spécifiée.
- Renvoie un tableau d’objets `Pierre`.

### getNom()
- Accède à l’attribut `nom_pierre` d’un objet `Pierre`.
- Retourne la chaîne de caractères représentant le nom.

### getFAQs()
- Sélectionne les FAQs non réservées aux administrateurs.
- Renvoie un tableau associatif (question, réponse).

### ajouterFaq($question, $reponse, $admin = false)
- Insère une nouvelle FAQ dans la table `faq`.
- Renvoie `true` si l’ajout est réussi, sinon `false`.

### supprimerFaq($question)
- Supprime la FAQ correspondant à la question passée en paramètre.
- Renvoie `true` si une ligne a été supprimée, sinon `false`.

### getFAQsAdmin()
- Sélectionne les FAQs réservées aux administrateurs (`admin = true`).
- Renvoie un tableau associatif (question, réponse).

### userHasStone($pseudo, $nom_pierre)
- Vérifie si l’utilisateur (table `pierre`) possède déjà la pierre nommée.
- Renvoie `true` si elle est trouvée, `false` sinon.

### addStoneToUser($pseudo, $nom_pierre)
- Ajoute une ligne dans la table `pierre` pour associer la pierre à l’utilisateur.
- Renvoie `true` ou `false` selon la réussite de l’insertion.

### getUserPseudoFromEmail($email)
- Récupère le pseudo d’un utilisateur depuis son email (table `utilisateurs`).
- Renvoie le pseudo sous forme de chaîne ou `false` si non trouvé.

### getAllPierres()
- Récupère la liste complète des pierres (table `geodex`).
- Renvoie un tableau d’objets `Pierre`.

### getUserStones($pseudo)
- Sélectionne les pierres découvertes par un utilisateur (jointure `geodex` / `pierre`).
- Renvoie un tableau d’objets `Pierre`.

### ajouterPierreAvecRarete($nom, $description, $rarete)
- Insère une nouvelle pierre dans la table `geodex` avec le nom, la description et la rareté.
- Renvoie `true` si l’insertion aboutit, sinon `false`.

### supprimerPierre($nom_pierre)
- Supprime une pierre de la table `geodex` par son nom.
- Renvoie `true` si la suppression a réussi, sinon `false`.