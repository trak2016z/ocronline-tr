<?php
// src/OCROnline/Entity/User.php
namespace OCROnline\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Table(name="users")
 * @Entity()
 */
class User implements UserInterface, \Serializable
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @Column(type="string", length=64)
     */
    private $password;

    /**
     * @Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ManyToMany(targetEntity="Role", inversedBy="users")
     * @JoinTable(name="roles_users")
     */
    private $roles;

    /**
     * @OneToMany(targetEntity="Document", mappedBy="user")
     */
    private $documents;

    /**
     * @OneToMany(targetEntity="Rank", mappedBy="user")
     */
    private $ranks;

    /**
     * @OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;

    public function __construct()
    {
        $this->isActive = true;
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array_map(function($r) {return $r->getType();}, $this->roles->getValues());
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}