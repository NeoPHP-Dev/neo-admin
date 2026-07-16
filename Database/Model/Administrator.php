<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\Database\Model;

use Neo\Core\Database\ORM\Model\AbstractModel;

class Administrator extends AbstractModel 
{
    protected static ?string $table = 'administrator';
    protected array $hidden = [];
    
    public ?int $id = null;

    public string $username;

    public string $password;

    public ?\DateTime $created_at = null;

    public ?\DateTime $updated_at = null;

    public ?\DateTime $deleted_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        return $this->setAttribute('id', $id);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        return $this->setAttribute('username', $username);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        return $this->setAttribute('password', $password);
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTime $created_at): static
    {
        return $this->setAttribute('created_at', $created_at);
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTime $updated_at): static
    {
        return $this->setAttribute('updated_at', $updated_at);
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTime $deleted_at): static
    {
        return $this->setAttribute('deleted_at', $deleted_at);
    }
}