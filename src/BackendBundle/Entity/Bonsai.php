<?php

namespace BackendBundle\Entity;

/**
 * Bonsai
 */
class Bonsai
{
    /**
     * @var integer
     */
    private $idbonsai;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var boolean
     */
    private $riego;

    /**
     * @var boolean
     */
    private $abono;

    /**
     * @var boolean
     */
    private $transplante;

    /**
     * @var boolean
     */
    private $pulverizar;

    /**
     * @var \DateTime
     */
    private $createdat;

    /**
     * @var string
     */
    private $imgpredefinida;


    /**
     * Get idbonsai
     *
     * @return integer
     */
    public function getIdbonsai()
    {
        return $this->idbonsai;
    }

    /**
     * Set tipo
     *
     * @param boolean $tipo
     *
     * @return Bonsai
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return boolean
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set riego
     *
     * @param boolean $riego
     *
     * @return Bonsai
     */
    public function setRiego($riego)
    {
        $this->riego = $riego;

        return $this;
    }

    /**
     * Get riego
     *
     * @return boolean
     */
    public function getRiego()
    {
        return $this->riego;
    }

    /**
     * Set abono
     *
     * @param boolean $abono
     *
     * @return Bonsai
     */
    public function setAbono($abono)
    {
        $this->abono = $abono;

        return $this;
    }

    /**
     * Get abono
     *
     * @return boolean
     */
    public function getAbono()
    {
        return $this->abono;
    }

    /**
     * Set transplante
     *
     * @param boolean $transplante
     *
     * @return Bonsai
     */
    public function setTransplante($transplante)
    {
        $this->transplante = $transplante;

        return $this;
    }

    /**
     * Get transplante
     *
     * @return boolean
     */
    public function getTransplante()
    {
        return $this->transplante;
    }

    /**
     * Set pulverizar
     *
     * @param boolean $pulverizar
     *
     * @return Bonsai
     */
    public function setPulverizar($pulverizar)
    {
        $this->pulverizar = $pulverizar;

        return $this;
    }

    /**
     * Get pulverizar
     *
     * @return boolean
     */
    public function getPulverizar()
    {
        return $this->pulverizar;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     *
     * @return Bonsai
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
     * Set imgpredefinida
     *
     * @param string $imgpredefinida
     *
     * @return Bonsai
     */
    public function setImgpredefinida($imgpredefinida)
    {
        $this->imgpredefinida = $imgpredefinida;

        return $this;
    }

    /**
     * Get imgpredefinida
     *
     * @return string
     */
    public function getImgpredefinida()
    {
        return $this->imgpredefinida;
    }
}
