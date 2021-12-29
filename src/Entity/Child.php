<?php

namespace App\Entity;

use App\Repository\ChildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChildRepository::class)
 */
class Child
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="child", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid()
     */
    private $contactPersons;

    public function __construct()
    {
        $this->contactPersons = new ArrayCollection();
    }
    /**
     * @return Collection|Address[]
     */
    public function getContactPersons(): Collection
    {
        return $this->contactPersons;
    }

    public function addContactPerson(Address $contactPerson): self
    {
        if (!$this->contactPersons->contains($contactPerson)) {
            $this->contactPersons[] = $contactPerson;
            $contactPerson->setChild($this);
        }

        return $this;
    }

    public function removeContactPerson(Address $contactPerson): self
    {
        $this->contactPersons->removeElement($contactPerson);

        return $this;
    }
}
