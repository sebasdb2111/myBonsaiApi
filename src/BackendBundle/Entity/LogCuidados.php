<?php

namespace BackendBundle\Entity;

/**
 * LogCuidados
 */
class LogCuidados
{
    /**
     * @var integer
     */
    private $idlogcuidados;

    /**
     * @var \DateTime
     */
    private $createdat;

    /**
     * @var string
     */
    private $cuidado;

    /**
     * @var \BackendBundle\Entity\UserBonsai
     */
    private $iduserbonsai;


    /**
     * Set idlogcuidados
     *
     * @param integer $idlogcuidados
     *
     * @return LogCuidados
     */
    public function setIdlogcuidados($idlogcuidados)
    {
        $this->idlogcuidados = $idlogcuidados;

        return $this;
    }

    /**
     * Get idlogcuidados
     *
     * @return integer
     */
    public function getIdlogcuidados()
    {
        return $this->idlogcuidados;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     *
     * @return LogCuidados
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * Set cuidado
     *
     * @param string $cuidado
     *
     * @return LogCuidados
     */
    public function setCuidado($cuidado)
    {
        $this->cuidado = $cuidado;

        return $this;
    }

    /**
     * Get cuidado
     *
     * @return string
     */
    public function getCuidado()
    {
        return $this->cuidado;
    }

    /**
     * Set iduserbonsai
     *
     * @param \BackendBundle\Entity\UserBonsai $iduserbonsai
     *
     * @return LogCuidados
     */
    public function setIduserbonsai(\BackendBundle\Entity\UserBonsai $iduserbonsai = null)
    {
        $this->iduserbonsai = $iduserbonsai;

        return $this;
    }

    /**
     * Get iduserbonsai
     *
     * @return \BackendBundle\Entity\UserBonsai
     */
    public function getIduserbonsai()
    {
        return $this->iduserbonsai;
    }
}

