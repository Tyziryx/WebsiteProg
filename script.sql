-- Table utilisateurs
CREATE TABLE utilisateurs (
    id SERIAL PRIMARY KEY,       -- Ajout de l'id pour l'utilisateur
    pseudo VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe TEXT NOT NULL,
    admin BOOLEAN DEFAULT FALSE
);

-- Table geodex (pierres)
CREATE TABLE geodex (
    nom_pierre VARCHAR(100) UNIQUE NOT NULL PRIMARY KEY,
    rarete INT NOT NULL,
    description TEXT,
    image VARCHAR(255) -- Stocke l'URL de l'image
);

-- Table pierre (liens entre utilisateurs et pierres)
CREATE TABLE pierre (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    pierre_id INT NOT NULL,
    obtenu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (pierre_id) REFERENCES geodex(id) ON DELETE CASCADE
);

-- Table faq
CREATE TABLE faq (
    id SERIAL PRIMARY KEY,       -- identifiant unique pour chaque question
    question TEXT NOT NULL,
    reponse TEXT NOT NULL,
    admin BOOLEAN DEFAULT FALSE -- champ pour déterminer si la question est dédié au backoffice
);

