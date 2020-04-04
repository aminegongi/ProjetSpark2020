<?php

namespace PlatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plat
 *
 * @ORM\Table(name="plat")
 * @ORM\Entity(repositoryClass="PlatBundle\Repository\PlatRepository")
 */
class Plat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="image0", type="string", length=255, nullable=false)
     */
    private $image0;

    /**
     * @var string
     *
     * @ORM\Column(name="image1", type="string", length=255, nullable=true)
     */
    private $image1;

    /**
     * @var string
     *
     * @ORM\Column(name="image2", type="string", length=255, nullable=true)
     */
    private $image2;

    /**
     * @var string
     *
     * @ORM\Column(name="image3", type="string", length=255, nullable=true)
     */
    private $image3;

    /**
     * @var string
     *
     * @ORM\Column(name="image4", type="string", length=255, nullable=true)
     */
    private $image4;

    /**
     * @return string
     */
    public function getImage5()
    {
        return $this->image5;
    }

    /**
     * @param string $image5
     */
    public function setImage5($image5)
    {
        $this->image5 = $image5;
    }

    /**
     * this attribute is always set to null, and necessary for multiple file selection
     * @var string
     *
     * @ORM\Column(name="image5", type="string", length=255, nullable=true)
     */
    private $image5;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulte", type="string", length=255)
     */
    private $difficulte;

    /**
     * @var int
     *
     * @ORM\Column(name="tempsPrepa", type="integer")
     */
    private $tempsPrepa;

    /**
     * @var int
     *
     * @ORM\Column(name="tempsCuisson", type="integer")
     */
    private $tempsCuisson;

    /**
     * @var string
     *
     * @ORM\Column(name="hfr", type="string", length=255)
     */
    private $hfr;

    /**
     * @var string
     *
     * @ORM\Column(name="meteo", type="string", length=255)
     */
    private $meteo;

    /**
     * Many plats have Many humeur.
     * @ORM\ManyToMany(targetEntity="Humeur")
     * @ORM\JoinTable(name="Humeur_plat",
     *      joinColumns={@ORM\JoinColumn(name="Plat_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="humeur_id", referencedColumnName="id")}
     *      )
     */
    private $humeur;

    /**
     * @return mixed
     */
    public function getHumeur()
    {
        return $this->humeur;
    }

    /**
     * @param mixed $humeur
     */
    public function setHumeur($humeur)
    {
        $this->humeur = $humeur;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="preparation", type="text")
     */
    private $preparation;

    /**
     * Many plats have Many maladies a eviter.
     * @ORM\ManyToMany(targetEntity="\MaladieBundle\Entity\Maladie")
     * @ORM\JoinTable(name="aEviter",
     *      joinColumns={@ORM\JoinColumn(name="Plat_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="maladie_id", referencedColumnName="id")}
     *      )
     */
    private $aEviter;

    /**
     * Many plats have Many maladies a reccomander.
     * @ORM\ManyToMany(targetEntity="\MaladieBundle\Entity\Maladie")
     * @ORM\JoinTable(name="aReccomander",
     *      joinColumns={@ORM\JoinColumn(name="Plat_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="Maladie_id", referencedColumnName="id")}
     *      )
     */
    private $aReccomander;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrPortion", type="integer")
     */
    private $nbrPortion;

    /**
     * @var string
     *
     * @ORM\Column(name="nomPortion", type="string", length=255)
     */
    private $nomPortion;

    /**
     * @var string
     *
     * @ORM\Column(name="ingredient", type="text")
     */
    private $ingredient;

    /**
     * Many plats have Many Ustensiles.
     * @ORM\ManyToMany(targetEntity="Ustensiles")
     * @ORM\JoinTable(name="plats_ustensiles",
     *      joinColumns={@ORM\JoinColumn(name="Plat_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="Ustensiles_id", referencedColumnName="id")}
     *      )
     */
    private $ustensiles;

    /**
     * @ORM\ManyToOne(targetEntity="Typeplat")
     * @ORM\JoinColumn(
     *     name="type",
     *     referencedColumnName="id",
     * )
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="specialite")
     * @ORM\JoinColumn(
     *     name="specialite",
     *     referencedColumnName="id",
     * )
     */
    private $specialite;

    /**
     * Many plats have Many notes.
     * @ORM\ManyToMany(targetEntity="Note")
     * @ORM\JoinTable(name="plats_notes",
     *      joinColumns={@ORM\JoinColumn(name="Plat_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="notes_id", referencedColumnName="id")}
     *      )
     */
    private $note;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Plat
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set image0
     *
     * @param string $image0
     *
     * @return Plat
     */
    public function setImage0($image0)
    {
        $this->image0 = $image0;

        return $this;
    }

    /**
     * Get image0
     *
     * @return string
     */
    public function getImage0()
    {
        return $this->image0;
    }

    /**
     * Set image1
     *
     * @param string $image1
     *
     * @return Plat
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return string
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set image2
     *
     * @param string $image2
     *
     * @return Plat
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return string
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set image3
     *
     * @param string $image3
     *
     * @return Plat
     */
    public function setImage3($image3)
    {
        $this->image3 = $image3;

        return $this;
    }

    /**
     * Get image3
     *
     * @return string
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * Set image4
     *
     * @param string $image4
     *
     * @return Plat
     */
    public function setImage4($image4)
    {
        $this->image4 = $image4;

        return $this;
    }

    /**
     * Get image4
     *
     * @return string
     */
    public function getImage4()
    {
        return $this->image4;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Plat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set difficulte
     *
     * @param string $difficulte
     *
     * @return Plat
     */
    public function setDifficulte($difficulte)
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    /**
     * Get difficulte
     *
     * @return string
     */
    public function getDifficulte()
    {
        return $this->difficulte;
    }

    /**
     * Set tempsPrepa
     *
     * @param string $tempsPrepa
     *
     * @return Plat
     */
    public function setTempsPrepa($tempsPrepa)
    {
        $this->tempsPrepa = $tempsPrepa;

        return $this;
    }

    /**
     * Get tempsPrepa
     *
     * @return string
     */
    public function getTempsPrepa()
    {
        return $this->tempsPrepa;
    }

    /**
     * Set tempsCuisson
     *
     * @param integer $tempsCuisson
     *
     * @return Plat
     */
    public function setTempsCuisson($tempsCuisson)
    {
        $this->tempsCuisson = $tempsCuisson;

        return $this;
    }

    /**
     * Get tempsCuisson
     *
     * @return int
     */
    public function getTempsCuisson()
    {
        return $this->tempsCuisson;
    }

    /**
     * Set hfr
     *
     * @param string $hfr
     *
     * @return Plat
     */
    public function setHfr($hfr)
    {
        $this->hfr = $hfr;

        return $this;
    }

    /**
     * Get hfr
     *
     * @return string
     */
    public function getHfr()
    {
        return $this->hfr;
    }

    /**
     * Set meteo
     *
     * @param string $meteo
     *
     * @return Plat
     */
    public function setMeteo($meteo)
    {
        $this->meteo = $meteo;

        return $this;
    }

    /**
     * Get meteo
     *
     * @return string
     */
    public function getMeteo()
    {
        return $this->meteo;
    }


    /**
     * Set preparation
     *
     * @param string $preparation
     *
     * @return Plat
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return string
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * @return mixed
     */
    public function getAEviter()
    {
        return $this->aEviter;
    }

    /**
     * @param mixed $aEviter
     */
    public function setAEviter($aEviter)
    {
        $this->aEviter = $aEviter;
    }

    /**
     * @return mixed
     */
    public function getAReccomander()
    {
        return $this->aReccomander;
    }

    /**
     * @param mixed $aReccomander
     */
    public function setAReccomander($aReccomander)
    {
        $this->aReccomander = $aReccomander;
    }





    /**
     * Set nbrPortion
     *
     * @param integer $nbrPortion
     *
     * @return Plat
     */
    public function setNbrPortion($nbrPortion)
    {
        $this->nbrPortion = $nbrPortion;

        return $this;
    }

    /**
     * Get nbrPortion
     *
     * @return int
     */
    public function getNbrPortion()
    {
        return $this->nbrPortion;
    }

    /**
     * Set nomPortion
     *
     * @param string $nomPortion
     *
     * @return Plat
     */
    public function setNomPortion($nomPortion)
    {
        $this->nomPortion = $nomPortion;

        return $this;
    }

    /**
     * Get nomPortion
     *
     * @return string
     */
    public function getNomPortion()
    {
        return $this->nomPortion;
    }

    /**
     * Set ingredient
     *
     * @param string $ingredient
     *
     * @return Plat
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return string
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * @return mixed
     */
    public function getUstensiles()
    {
        return $this->ustensiles;
    }

    /**
     * @param mixed $ustensiles
     */
    public function setUstensiles($ustensiles)
    {
        $this->ustensiles = $ustensiles;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @param mixed $specialite
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ustensiles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->note = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ustensile
     *
     * @param \PlatBundle\Entity\Ustensiles $ustensile
     *
     * @return Plat
     */
    public function addUstensile(\PlatBundle\Entity\Ustensiles $ustensile)
    {
        $this->ustensiles[] = $ustensile;

        return $this;
    }

    /**
     * Remove ustensile
     *
     * @param \PlatBundle\Entity\Ustensiles $ustensile
     */
    public function removeUstensile(\PlatBundle\Entity\Ustensiles $ustensile)
    {
        $this->ustensiles->removeElement($ustensile);
    }

    /**
     * Add note
     *
     * @param \PlatBundle\Entity\Note $note
     *
     * @return Plat
     */
    public function addNote(\PlatBundle\Entity\Note $note)
    {
        $this->note[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \PlatBundle\Entity\Note $note
     */
    public function removeNote(\PlatBundle\Entity\Note $note)
    {
        $this->note->removeElement($note);
    }
}
