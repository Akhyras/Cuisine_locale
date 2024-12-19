<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(min: 10)]
    #[Assert\NotBlank]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'owner')]
    private Collection $recipes;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

   /**
     * @return Collection<int, Recipe>
     */
   public function getRecipes(): Collection
   {
       return $this->recipes;
   }

   public function addRecipe(Recipe $recipe): static
   {
       if (!$this->recipes->contains($recipe)) {
           $this->recipes->add($recipe);
           $recipe->setOwner($this);
       }

       return $this;
   }

   public function removeRecipe(Recipe $recipe): static
   {
       if ($this->recipes->removeElement($recipe)) {
           // set the owning side to null (unless already changed)
           if ($recipe->getOwner() === $this) {
               $recipe->setOwner(null);
           }
       }

       return $this;
   }

   // Méthodes requises par UserInterface

   public function getRoles(): array
   {
       return array_unique(['ROLE_USER']);
   }

   public function getUserIdentifier(): string
   {
       return (string) $this->email; // Utilisez l'email comme identifiant de l'utilisateur
   }

   public function eraseCredentials(): void
   {
       // Rien à faire ici, car nous ne stockons pas de données sensibles.
   }
}
