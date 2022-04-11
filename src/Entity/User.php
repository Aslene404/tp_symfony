<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert; use Symfony\Component\Security\Core\User\UserInterface; use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields:"username", message:"There is already an account with this username")] // Ceci pour dire que le nom de l’utilisateur doit être unique 
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')] // Ceci pour dire que le nom de l’utilisateur doit être unique 
#[ORM\Table(name:"`user`")] // Ceci pour éviter le conflit avec le mot clé user de PostgreSQL
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $username;

    
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    
    #[Assert\Length(min : 8, minMessage:"Your password must be at least 8 characters long")] 
    #[Assert\EqualTo(propertyPath:'confirm_password',message: "password not confirmed try again")] 
    private $password; 
    #[Assert\EqualTo(propertyPath:'password')] 
    public $confirm_password;

    public function eraseCredentials(){} 
    public function getSalt(){} 
    public function getUserIdentifier(): string { return (string) $this->email; } 
    public function getRoles(): array { $roles = $this->roles; // guarantee every user at least has ROLE_USER 
        $roles[] = 'ROLE_USER'; return array_unique($roles); }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
