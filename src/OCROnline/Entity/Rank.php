<?php
// src/OCROnline/Entity/Rank.php
namespace OCROnline\Entity;

/**
 * @Table(name="ranks")
 * @Entity()
 */
class Rank
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ManyToOne(targetEntity="User")
     */
    private $user;

    /** 
     * @ManyToOne(targetEntity="Document")
     */
    private $document;

    /**
     * @Column(name="is_positive", type="boolean")
     */
    private $isPositive;
}