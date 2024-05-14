<?php 

namespace entity;
use Lib\Utility;
class Comment
{
    private $id;
    private $user;
    private $video;
    private $content;
    private $created_at;
    private $updated_at;
    private $table_name = "COMMENT";


    function __construct(){
        
        $this->id = Utility::generate_id();
        $this->created_at = new \DateTime;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of videoId
     */ 
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set the value of videoId
     *
     * @return  self
     */ 
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of table_name
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * Set the value of table_name
     */
    public function setTableName($table_name): self
    {
        $this->table_name = $table_name;

        return $this;
    }
}
