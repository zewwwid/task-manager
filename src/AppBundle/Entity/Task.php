<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Задача.
 * 
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task {

    #<editor-fold defaultstate="collapsed" desc="Поля">

    /**
     * Идентификатор.
     * 
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Название.
     *
     * @ORM\Column(name="`name`", type="string", length=255, nullable=false)
     */
    protected $name;
    
    /**
     * Текст.
     *
     * @ORM\Column(name="`text`", type="text", nullable=true)
     */
    protected $text;
       
    /**
     * Статус.
     *
     * @ORM\Column(name="`status`", type="string", 
     *      columnDefinition="ENUM('Новая', 'В работе', 'Закрыта')", 
     *      nullable=false
     * )
     */
    protected $status;

    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Связи">
    
    /**
     * Ответственный.
     * 
     * @ORM\ManyToOne(targetEntity="Administrator", inversedBy="tasks")
     * @ORM\JoinColumn(name="responsible", referencedColumnName="id")
     **/
    protected $responsible;
    
    /**
     * Документы прикрепленные к задаче.
     * 
     * @ORM\OneToMany(targetEntity="Document", mappedBy="task")
     **/
    protected $documents;
    
    #</editor-fold>

    #<editor-fold defaultstate="collapsed" desc="Методы">
    
    /**
     * Конструктор.
     */
    public function __construct() {
        $this->documents = new ArrayCollection();
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
     * Get name
     *
     * @return string Название.
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Get text
     *
     * @return string Текст.
     */
    public function getText() {
        return $this->text;
    }
          
    /**
     * Get status
     *
     * @return string Статус.
     */
    public function getStatus() {
        return $this->status;
    }
    
    /**
     * Get responsible
     * 
     * @return \AppBundle\Entity\Administrator Ответственный.
     */
    public function getResponsible(){
        return $this->responsible;
    }
    
    /**
     * Get documents
     * 
     * @return \Doctrine\Common\Collections\Collection Документы прикрепленные к задаче.
     */
    public function getDocuments() {
        return $this->documents;
    }
    
    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Сеттеры">
    
    /**
     * Set name
     *
     * @param string $name Название.
     * @return Task
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }
    
    /**
     * Set text
     *
     * @param string $text Текст.
     * @return Task
     */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }
 
    /**
     * Set status
     *
     * @param string $status Статус.
     * @return Task
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }
    
    /**
     * Set responsible
     * 
     * @param \AppBundle\Entity\Administrator $responsible
     * @return Task
     */
    public function setResponsible(\AppBundle\Entity\Administrator $responsible = null) {
        $this->responsible = $responsible;
        
        return $this;
    }
    #</editor-fold>
       
    #<editor-fold defaultstate="collapsed" desc="Add">
    
    /**
     * Add document
     * 
     * @param \AppBundle\Entity\Document $document Документ прикрепляемый к задаче.
     * @return Task
     */
    public function addDocument(\AppBundle\Entity\Document $document) {
        $this->documents[] = $document;
        
        return $this;
    }
    
    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Remove">
    
    /**
     * Remove document
     * 
     * @param \AppBundle\Entity\Document $document Документ открепляемый от задачи.
     */
    public function removeDocument(\AppBundle\Entity\Document $document) {
        $this->documents->removeElement($document);
    }
    
    #</editor-fold>

    #</editor-fold>    
}
