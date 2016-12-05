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
     * @Column(type="string", length=150, nullable=true)
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
     * @Column(name="recognized_text", type="text", nullable=true)
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

    private $fileupload;

    public function __construct()
    {
        $this->creationDatetime = new \DateTime();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getFileupload()
    {
        return $this->fileupload;
    }

    public function setFileupload($fileupload)
    {
        $this->fileupload = $fileupload;
        $this->readFileContents();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getPrivacy()
    {
        return $this->privacy;
    }

    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }

    public function getAbstract()
    {
        return $this->abstract;
    }

    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    public function getFileContent()
    {
        return $this->fileContent;
    }

    public function setFileContent($fileContent)
    {
        $this->fileContent = $fileContent;
    }

    public function getCreationDatetime()
    {
        return $this->creationDatetime;
    }

    public function setCreationDatetime($creationDatetime)
    {
        $this->creationDatetime = $creationDatetime;
    }

    public function readFileContents()
    {
        if ($this->fileupload->isValid())
        {
            $this->setMimeType($this->fileupload->getMimeType());
            $this->abstract = "";
            $this->creationDatetime = new \DateTime();
            
            $tess = new \TesseractOCR($this->fileupload->getPathname());
            $this->recognizedText = $tess->run();

            var_dump($this->recognizedText);
            $this->fileContent = file_get_contents($this->fileupload->getPathname());
        }
    }
}