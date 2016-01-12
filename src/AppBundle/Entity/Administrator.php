<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Администратор.
 * 
 * @ORM\Entity
 * @ORM\Table(name="administrators")
 */
class Administrator {

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
     * ФИО.
     *
     * @ORM\Column(name="`fullname`", type="string", length=255, 
     *      nullable=false
     * )
     */
    protected $fullname;

    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Связи">
    
    /**
     * Задачи в которых администратор является ответственным.
     * 
     * @ORM\OneToMany(targetEntity="Task", mappedBy="responsible")
     **/
    protected $tasks;
    
    /**
     * Документы загруженные администратором.
     * 
     * @ORM\OneToMany(targetEntity="Document", mappedBy="administrator")
     **/
    protected $documents;
    
    #</editor-fold>

    #<editor-fold defaultstate="collapsed" desc="Методы">
    
    /**
     * Конструктор.
     */
    public function __construct() {
        $this->tasks = new ArrayCollection();
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
     * Get fullname
     *
     * @return string ФИО.
     */
    public function getFullname() {
        return $this->fullname;
    }
        
    /**
     * Get tasks
     * 
     * @return \Doctrine\Common\Collections\Collection Задачи в которых администратор является ответственным.
     */
    public function getTasks() {
        return $this->tasks;
    }
    
    /**
     * Get documents
     * 
     * @return \Doctrine\Common\Collections\Collection Документы загруженные администратором.
     */
    public function getDocuments() {
        return $this->documents;
    }
    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Сеттеры">
    
    /**
     * Set fullname
     *
     * @param string $fullname ФИО.
     * @return Administrator
     */
    public function setFullname($fullname) {
        $this->fullname = $fullname;

        return $this;
    }
        
    #</editor-fold>

    #</editor-fold>
}
