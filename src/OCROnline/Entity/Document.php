<?php
// src/OCROnline/Entity/Document.php
namespace OCROnline\Entity;

/**
 * @Table(name="documents")
 * @Entity()
 */
class Document
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
     * @OneToMany(targetEntity="Rank", mappedBy="document")
     */
    private $ranks;

    /**
     * @OneToMany(targetEntity="Comment", mappedBy="document")
     */
    private $comments;

    /**
     * @Column(type="string", length=64)
     */
    private $title;

    /**
     * @Column(type="string", length=150)
     */
    private $abstract;

    /**
     * @Column(name="file_content", type="blob")
     */
    private $fileContent;

    /**
     * @Column(name="mime_type", type="string", length=30)
     */
    private $mimeType;

    /**
     * @Column(name="recognized_text", type="text")
     */
    private $recognizedText;

    /**
     * @Column(type="integer")
     */
    private $privacy;

    /**
     * @Column(name="creation_datetime", type="datetime")
     */
    private $creationDatetime;

    public function __construct()
    {
        $this->creationDatetime = new \DateTime();
    }
}