<?php
namespace JJ\WeddingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JJ\WeddingBundle\Entity\Document
 */
class Document {
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $filename
     */
    private $filename;

    /**
     * @var string $path
     */
    private $path;

    /**
     * @var string $mimetype
     */
    private $mimetype;

    /**
     * @var string $hash
     */
    private $hash;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $galleryName;

    /**
     * @var integer
     */
    private $orderInGallery;

    private $file;

    private $temp;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Default __toString.
     */
    public function __toString() {
        return $this->getFilename();
    }

    /**
     * Set filename
     *
     * @param string  $filename
     * @return Document
     */
    public function setFilename( $filename ) {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Set path
     *
     * @param string  $path
     * @return Document
     */
    public function setPath( $path ) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/media';
    }

    /**
     * Set mimetype
     *
     * @param string  $mimetype
     * @return Document
     */
    public function setMimetype( $mimetype ) {
        $this->mimetype = $mimetype;

        return $this;
    }

    /**
     * Get mimetype
     *
     * @return string
     */
    public function getMimetype() {
        return $this->mimetype;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash() {
        return $this->hash;
    }

    /**
     * Set hash
     *
     * @param string  $hash
     * @return DocumentedEntity
     */
    public function setHash( $hash ) {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Generate hash
     *
     * @param string  $hash
     * @return DocumentedEntity
     */
    public function generateHash( $data ) {
        $this->hash = hash( 'sha512', $data );

        return $this;
    }

    /**
     * Generate hash
     *
     * @param string  $filename
     * @return DocumentedEntity
     */
    public function generateHashFromFile( $file ) {
        $this->hash = hash_file( 'sha512', $file );

        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Document
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set galleryName
     *
     * @param string $galleryName
     * @return Document
     */
    public function setGalleryName($galleryName)
    {
        $this->galleryName = $galleryName;
    
        return $this;
    }

    /**
     * Get galleryName
     *
     * @return string 
     */
    public function getGalleryName()
    {
        return $this->galleryName;
    }

    /**
     * Set orderInGallery
     *
     * @param integer $orderInGallery
     * @return Document
     */
    public function setOrderInGallery($orderInGallery)
    {
        $this->orderInGallery = $orderInGallery;
    
        return $this;
    }

    /**
     * Get orderInGallery
     *
     * @return integer 
     */
    public function getOrderInGallery()
    {
        return $this->orderInGallery;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile($file = null)
    {
        if('array' == gettype($file)){
            // if there are multiple files uploaded
            foreach($file as $single){
                $this->file = $single;

                // check if we have an old image path
                if (is_file($this->getAbsolutePath())) {
                    // store the old name to delete after the update
                    $this->temp = $this->getAbsolutePath();
                } else {
                    $this->path = 'initial';
                }
            }
        }
        else{
            // if there is only one file
            $this->file = $file;

            // check if we have an old image path
            if (is_file($this->getAbsolutePath())) {
                // store the old name to delete after the update
                $this->temp = $this->getAbsolutePath();
            } else {
                $this->path = 'initial';
            }
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * life cycle cacllback: PrePersist/PreUpdate
     */
    public function preUpload()
    {

        if(null !== $this->getFile()){
            // generate a uniquename
            $this->generateHashFromFile($this->getFile());
            // get filetype
            $this->mimetype = $this->getFile()->guessExtension();
            $this->path = $this->getHash() . '.' . $this->getFile()->guessExtension();
        }


    }

    /**
     * life cycle cacllback: PreRemove
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * life cycle cacllback: PostRemove
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * life cycle cacllback: PostPersist/PostUpdate
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    // this function is intended for a symfony application-generated file.
    // not currently used
    /*
    public function write($data) {

        $this->path = $this->getDir();

        $this->generateHash($data);
        
        if(!realpath($this->path)){
            mkdir( $this->path, 0775, true );
        }
        $this->path=realpath( $this->path );

        file_put_contents($this->getFullName(), $data);
    }
    */

}