<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Документ.
 * 
 * @ORM\Entity
 * @ORM\Table(name="documents",
 *      indexes={
 *          @ORM\Index(name="documents_filename_idx", columns={"filename"})
 *      }
 * )
 */
class Document {

    #<editor-fold defaultstate="collapsed" desc="Поля">

    /**
     * Идентификатор.
     * 
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Serializer\Groups({"card"})
     */
    protected $id;

    /**
     * Имя файла.
     *
     * @ORM\Column(name="`filename`", type="string", length=255, 
     *      nullable=false
     * )
     * 
     * @Serializer\Groups({"card"})
     */
    protected $filename;   

    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Связи">
    
    /**
     * Задача к которой прикреплен документ.
     * 
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="documents")
     * @ORM\JoinColumn(name="task", referencedColumnName="id")
     **/
    protected $task;
    
    /**
     * Клиент к которому прикреплен документ.
     * 
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="documents")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     **/
    protected $client;
    
    /**
     * Администратор загрузивший документ.
     * 
     * @ORM\ManyToOne(targetEntity="Administrator", inversedBy="documents")
     * @ORM\JoinColumn(name="administrator", referencedColumnName="id")
     **/
    protected $administrator;
    
    #</editor-fold>

    #<editor-fold defaultstate="collapsed" desc="Методы">
    
    /**
     * Конструктор.
     */
    public function __construct() {
    }
    
    #<editor-fold defaultstate="collapsed" desc="Геттеры">
    
    /**
     * Get id
     *
     * @return integer Идентификатор.
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Get filename
     *
     * @return string Имя файла.
     */
    public function getFilename() {
        return $this->filename;
    }
    
    /**
     * Get task
     * 
     * @return \AppBundle\Entity\Task Задача к которой прикреплен документ.
     */
    public function getTask(){
        return $this->task;
    }
        
    /**
     * Get client
     * 
     * @return \AppBundle\Entity\Client Клиент к которому прикреплен документ.
     */
    public function getClient(){
        return $this->client;
    }
    
    /**
     * Get administrator
     * 
     * @return \AppBundle\Entity\Administrator Администратор загрузивший документ.
     */
    public function getAdministrator(){
        return $this->administrator;
    }
    
    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Сеттеры">
    
    /**
     * Set filename
     *
     * @param string $filename Имя файла.
     * @return Document
     */
    public function setFilename($filename) {
        $this->filename = $filename;

        return $this;
    }
        
    /**
     * Set task
     * 
     * @param \AppBundle\Entity\Task $task Задача к которой прикреплен документ.
     * @return Document
     */
    public function setTask(\AppBundle\Entity\Task $task = null) {
        $this->task = $task;
        
        return $this;
    }
    
    /**
     * Set client
     * 
     * @param \AppBundle\Entity\Client $client Клиент к которому прикреплен документ.
     * @return Document
     */
    public function setClient(\AppBundle\Entity\Client $client = null) {
        $this->client = $client;
        
        return $this;
    }
    
    /**
     * Set administrator
     * 
     * @param \AppBundle\Entity\Administrator $administrator Администратор загрузивший документ.
     * @return Document
     */
    public function setAdministrator(\AppBundle\Entity\Administrator $administrator = null) {
        $this->administrator = $administrator;
        
        return $this;
    }
    #</editor-fold>

    #</editor-fold>
}
