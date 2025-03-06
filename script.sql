-- Table utilisateurs
CREATE TABLE utilisateurs (
    pseudo VARCHAR(50) PRIMARY KEY,       -- Le pseudo comme clé primaire
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe TEXT NOT NULL,
    admin BOOLEAN DEFAULT FALSE
);

-- Table geodex (pierres)
CREATE TABLE geodex (
    nom_pierre VARCHAR(100) PRIMARY KEY,  -- Le nom de la pierre comme clé primaire
    rarete INT NOT NULL,
    description TEXT,
    image VARCHAR(255)                    -- Stocke l'URL de l'image
);

-- Table pierre (liens entre utilisateurs et pierres)
CREATE TABLE pierre (
    user_id VARCHAR(50) NOT NULL,         -- Le pseudo de l'utilisateur
    pierre_id VARCHAR(100) NOT NULL,      -- Le nom de la pierre
    obtenu BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id, pierre_id),     -- La clé primaire est une combinaison de user_id et pierre_id
    FOREIGN KEY (user_id) REFERENCES utilisateurs(pseudo) ON DELETE CASCADE,
    FOREIGN KEY (pierre_id) REFERENCES geodex(nom_pierre) ON DELETE CASCADE
);

-- Table faq
CREATE TABLE faq (
    question TEXT PRIMARY KEY,            -- La question comme clé primaire
    reponse TEXT NOT NULL,
    admin BOOLEAN DEFAULT FALSE           -- Champ pour déterminer si la question est dédiée au backoffice
);
