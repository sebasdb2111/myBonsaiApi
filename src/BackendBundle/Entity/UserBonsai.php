<?php

namespace BackendBundle\Entity;

/**
 * UserBonsai
 */
class UserBonsai
{
    /**
     * @var integer
     */
    private $iduserbonsai;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $edad;

    /**
     * @var string
     */
    private $fechaadquisicion;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $imgbonsai;

    /**
     * @var \BackendBundle\Entity\Bonsai
     */
    private $idbonsai;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $iduser;


    /**
     * Set iduserbonsai
     *
     * @param integer $iduserbonsai
     *
     * @return UserBonsai
     */
    public function setIduserbonsai($iduserbonsai)
    {
        $this->iduserbonsai = $iduserbonsai;

        return $this;
    }

    /**
     * Get iduserbonsai
     *
     * @return integer
     */
    public function getIduserbonsai()
    {
        return $this->iduserbonsai;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return UserBonsai
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set edad
     *
     * @param string $edad
     *
     * @return UserBonsai
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return string
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set fechaadquisicion
     *
     * @param \DateTime $fechaadquisicion
     *
     * @return UserBonsai
     */

    public function setFechaadquisicion($fechaadquisicion)
    {
        $this->fechaadquisicion = $fechaadquisicion;

        return $this;
    }

    /**
     * Get fechaadquisicion
     *
     * @return string
     */
    public function getFechaadquisicion()
    {
        return $this->fechaadquisicion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return UserBonsai
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
     * Set imgbonsai
     *
     * @param string $imgbonsai
     *
     * @return UserBonsai
     */
    public function setImgbonsai($imgbonsai)
    {
        $this->imgbonsai = $imgbonsai;

        return $this;
    }

    /**
     * Get imgbonsai
     *
     * @return string
     */
    public function getImgbonsai()
    {
        return $this->imgbonsai;
    }

    /**
     * Set idbonsai
     *
     * @param \BackendBundle\Entity\Bonsai $idbonsai
     *
     * @return UserBonsai
     */
    public function setIdbonsai(\BackendBundle\Entity\Bonsai $idbonsai = null)
    {
        $this->idbonsai = $idbonsai;

        return $this;
    }

    /**
     * Get idbonsai
     *
     * @return \BackendBundle\Entity\Bonsai
     */
    public function getIdbonsai()
    {
        return $this->idbonsai;
    }

    /**
     * Set iduser
     *
     * @param \BackendBundle\Entity\User $iduser
     *
     * @return UserBonsai
     */
    public function setIduser(\BackendBundle\Entity\User $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \BackendBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }
}
