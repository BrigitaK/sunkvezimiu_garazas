<?php

namespace App\Entity;

use App\Repository\MechanicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MechanicRepository::class)
 */
class Mechanic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     *   * @Assert\NotBlank(message="Vardas negali buti tuscias")
     * @Assert\Length(
     *      min = 3,
     *      max = 64,
     *      minMessage = "Vardas per trumpas. Turi but bent {{ limit }} ilgio",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Surname should not be blank.")
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "Surname must be at least {{ limit }} characters long.",
     *      maxMessage = "Surname cannot be longer than {{ limit }} characters."
     * )
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity=Truck::class, mappedBy="mechanic")
     */
    private $trucks;

    public function __construct()
    {
        $this->trucks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection|Truck[]
     */
    public function getTrucks(): Collection
    {
        return $this->trucks;
    }

    public function addTruck(Truck $truck): self
    {
        if (!$this->trucks->contains($truck)) {
            $this->trucks[] = $truck;
            $truck->setMechanic($this);
        }

        return $this;
    }

    public function removeTruck(Truck $truck): self
    {
        if ($this->trucks->removeElement($truck)) {
            // set the owning side to null (unless already changed)
            if ($truck->getMechanic() === $this) {
                $truck->setMechanic(null);
            }
        }

        return $this;
    }
}
