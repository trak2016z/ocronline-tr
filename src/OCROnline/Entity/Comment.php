<?php
// src/OCROnline/Entity/Comment.php
namespace OCROnline\Entity;

/**
 * @Table(name="comments")
 * @Entity()
 */
class Comment
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
     * @Column(type="string", length=1000)
     */
    private $comment;

    /**
     * @Column(name="creation_datetime", type="datetime")
     */
    private $creationDatetime;

    public function __construct()
    {
        $this->creationDatetime = new \DateTime();
    }
}