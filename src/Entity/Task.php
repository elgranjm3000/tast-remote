<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{



    /**
     * @ORM\ManyToMany(targetEntity="Usuarios", inversedBy="task", cascade={"persist"})
     * @ORM\JoinTable(name="usuarios_task")
     **/
    private $usuarios;




// ...
 
    /**
     * @ORM\OneToMany(targetEntity="Files", mappedBy="task", cascade={"remove","persist"}, orphanRemoval=true)
     */
    protected $files;
 
    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->usuarios = new ArrayCollection();

    }


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
     * @ORM\Column(type="string", length=1,nullable=true)
     */
    private $status;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }


    

    /**
     * @return Collection|Files[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(Files $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setTask($this);
        }

        return $this;
    }

    public function removeFile(Files $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getTask() === $this) {
                $file->setTask(null);
            }
        }

        return $this;
    }





    /**
     * @return Collection|Usuarios[]
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuarios $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios[] = $usuario;
        }

        return $this;
    }

    public function removeUsuario(Usuarios $usuario): self
    {
        if ($this->usuarios->contains($usuario)) {
            $this->usuarios->removeElement($usuario);
        }

        return $this;
    }
}
