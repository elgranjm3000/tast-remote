<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{

    // ... 
    /**
     * @ORM\ManyToOne(targetEntity="Taskboard", inversedBy="task")
     * @ORM\JoinColumn(name="idtaskboad", referencedColumnName="id")
     */
    protected $taskboard;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $estado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechacreacion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechacomienzo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechafin;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $tiempo;

    /**
     * @ORM\Column(type="integer")
     */
    private $iduser;

    /**
     * @ORM\Column(type="integer")
     */
    private $idtaskboad;

    public function getId()
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        //return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFechacreacion(): ?\DateTimeInterface
    {
        return $this->fechacreacion;
    }

    public function setFechacreacion(\DateTimeInterface $fechacreacion): self
    {
        $this->fechacreacion = $fechacreacion;

        return $this;
    }

    public function getFechacomienzo(): ?\DateTimeInterface
    {
        return $this->fechacomienzo;
    }

    public function setFechacomienzo(?\DateTimeInterface $fechacomienzo): self
    {
        $this->fechacomienzo = $fechacomienzo;

        return $this;
    }

    public function getFechafin(): ?\DateTimeInterface
    {
        return $this->fechafin;
    }

    public function setFechafin(?\DateTimeInterface $fechafin): self
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    public function getTiempo(): ?string
    {
        return $this->tiempo;
    }

    public function setTiempo(string $tiempo): self
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdfile(): ?int
    {
        return $this->idfile;
    }

    public function setIdfile(int $idfile): self
    {
        $this->idfile = $idfile;

        return $this;
    }

    public function getIdtaskboad(): ?int
    {
        return $this->idtaskboad;
    }

    public function setIdtaskboad(int $idtaskboad): self
    {
        $this->idtaskboad = $idtaskboad;

        return $this;
    }

    public function getTaskboard(): ?taskboard
    {
        return $this->taskboard;
    }

    public function setTaskboard(?taskboard $taskboard): self
    {
        $this->taskboard = $taskboard;

        return $this;
    }
}
