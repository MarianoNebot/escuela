<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pais
 */
class Pais
{
    /**
     * @var integer
     */
    private $idPais;

    /**
     * @Assert\Type(
     *        type="string",
     *        message=" "
     *              )
     * @var string
     */
    private $descripcion;

    /**
     * @ORM\ManyToMany(targetEntity="Provincia", inversedBy="Pais")
     * @ORM\JoinColumn(name="ID_Provincia", referencedColumnName="Provincia_ID", nullable=false)
     * @ORM\JoinTable(name="Provincia")
     */
    protected $Provincias;

    /**
     * Tag constructor.
     */
    public function __construct() {
        $this->Provincias = new ArrayCollection();
    }

    /**
     * Get idPais
     *
     * @return integer
     */
    public function getIdPais()
    {
        return $this->idPais;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Pais
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param provincia|null $provincia
     * @return $this
     */
    public function addProvincia(Provincia $provincia = null)
    {
        $this->Provincias[] = $provincia;

        return $this;
    }

    /**
     *@return array
     */
    public function getProvincias()
    {
        return $this->Provincias->toarray();
    }
}

