<?php
// Namespace des classes de mon digramme de classe
namespace classe;

/**
 * Classe Pierre
 *
 * Représente une pierre avec des informations telles que son nom, sa description, sa rareté et son image.
 * Permet d'accéder et de modifier ces informations via des méthodes magiques.
 */
class Pierre {
    /**
     * @var string Le nom de la pierre.
     */
    public $nom_pierre;

    /**
     * @var string La description de la pierre.
     */
    public $description;

    /**
     * @var string L'image de la pierre (URL ou chemin vers l'image).
     */
    public $image;

    /**
     * @var string La rareté de la pierre (ex : commune, rare, épique, légendaire).
     */
    public $rarete;

    /**
     * Constructeur pour initialiser l'objet Pierre avec des informations.
     *
     * @param string $nom_pierre Le nom de la pierre. Par défaut : une chaîne vide.
     * @param string $description La description de la pierre. Par défaut : une chaîne vide.
     * @param string $image L'image de la pierre. Par défaut : une chaîne vide.
     * @param string $rarete La rareté de la pierre. Par défaut : une chaîne vide.
     */
    public function __construct($nom_pierre='', $description='', $image='', $rarete='') {
        $this->nom_pierre = $nom_pierre;
        $this->description = $description;
        $this->image = $image;
        $this->rarete = $rarete;
    }

    /**
     * Méthode magique pour accéder à une propriété de l'objet.
     *
     * Cette méthode permet d'accéder aux propriétés de l'objet en utilisant la syntaxe `$objet->propriete`.
     * Si la propriété existe, elle est retournée, sinon une exception est levée.
     *
     * @param string $property Le nom de la propriété à récupérer.
     * @return mixed La valeur de la propriété.
     * @throws Exception Si la propriété demandée n'existe pas.
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new Exception("Propriété '$property' introuvable.");
    }

    /**
     * Méthode magique pour modifier une propriété de l'objet.
     *
     * Cette méthode permet de modifier les propriétés de l'objet en utilisant la syntaxe `$objet->propriete = valeur`.
     * Si la propriété existe, elle est modifiée, sinon une exception est levée.
     *
     * @param string $property Le nom de la propriété à modifier.
     * @param mixed $value La nouvelle valeur à affecter à la propriété.
     * @throws Exception Si la propriété demandée n'existe pas.
     */
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception("Propriété '$property' introuvable.");
        }
    }
}
?>