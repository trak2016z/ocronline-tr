<?php
// src/OCROnline/Entity/User.php
namespace OCROnline\Entity;

/**
 * @Table(name="roles")
 * @Entity()
 */
class Role
{
    /**
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @Column(name="type", type="string", nullable=false, length=20)
     */
    private $type;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Role
     */
    public function setMessage($type)
    {
        $this->type = $type;
        return $this;
    }
}