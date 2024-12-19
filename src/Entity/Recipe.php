<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $recipeName = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\NotBlank(message: 'La latitude est obligatoire.')]
    #[Assert\Range(
        min: -90,
        max: 90,
        notInRangeMessage: 'La latitude doit être comprise entre {{ min }} et {{ max }}.'
    )]
    private ?float $recipeLatitude = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\NotBlank(message: 'La longitude est obligatoire.')]
    #[Assert\Range(
        min: -180,
        max: 180,
        notInRangeMessage: 'La longitude doit être comprise entre {{ min }} et {{ max }}.'
    )]
    private ?float $recipeLongitude = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recipes')]
    // #[Assert\NotBlank()]  // Commentez ou supprimez cette ligne
    #[ORM\JoinColumn(nullable: true)] // à remettre false une fois les login terminé
    private ?User $owner = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $recipeDescription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipeName(): ?string
    {
        return $this->recipeName;
    }

    public function setRecipeName(string $recipeName): static
    {
        $this->recipeName = $recipeName;

        return $this;
    }

    public function getRecipeLatitude(): ?float
    {
        return $this->recipeLatitude;
    }

    public function setRecipeLatitude(float $recipeLatitude): static
    {
        $this->recipeLatitude = $recipeLatitude;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getRecipeLongitude(): ?float
    {
    return $this->recipeLongitude;
    }

    public function setRecipeLongitude(?float $recipeLongitude): static
    {
    $this->recipeLongitude = $recipeLongitude;
    return $this;
    }

    public function getRecipeDescription(): ?string
    {
        return $this->recipeDescription;
    }

    public function setRecipeDescription(string $recipeDescription): static
    {
        $this->recipeDescription = $recipeDescription;

        return $this;
    }
}
