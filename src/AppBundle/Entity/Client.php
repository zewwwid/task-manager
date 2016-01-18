<?php

namespace AppBundle\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Клиент.
 * 
 * @ORM\Entity
 * @ORM\Table(name="clients",
 *      indexes={
 *          @ORM\Index(name="clients_fullname_idx", columns={"fullname"}),
 *          @ORM\Index(name="clients_email_idx", columns={"email"}),
 *          @ORM\Index(name="clients_phone_idx", columns={"phone"}),
 *          @ORM\Index(name="clients_status_idx", columns={"status"})
 *      }
 * )
 * 
 * @UniqueEntity(fields = "email", 
 *      message = "Клиент с таким Email уже существует"
 * )
 * 
 * @Serializer\XmlRoot("client")
 */
class Client {

    #<editor-fold defaultstate="collapsed" desc="Поля">

    /**
     * Идентификатор.
     * 
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *  
     * @Serializer\Groups({"list", "card"})
     */
    protected $id;

    /**
     * ФИО.
     *
     * @ORM\Column(name="`fullname`", type="string", length=255, 
     *      nullable=false
     * )
     * 
     * @Assert\NotBlank(message = "ФИО не может быть пустым")
     * @Assert\Length(max = 255, 
     *      maxMessage = "Максимальная длина ФИО 255 символов"
     * )
     * 
     * @Serializer\Groups({"list", "card"})
     */
    protected $fullname;

    /**
     * Email.
     *
     * @ORM\Column(name="`email`", type="string", length=64, nullable=false)
     * 
     * @Assert\NotBlank(message = "Email не может быть пустым")
     * @Assert\Email(message = "Email '{{ value }}' не валидный.")
     * @Assert\Length(max = 64, 
     *      maxMessage = "Максимальная длина Email 64 символоа"
     * )
     * 
     * @Serializer\Groups({"list", "card"})
     */
    protected $email;

    /**
     * Телефон.
     *
     * @ORM\Column(name="`phone`", type="string", length=20, nullable=true)
     * 
     * @Assert\Length(max = 20, 
     *      maxMessage = "Максимальная длина Телефона 20 символов"
     * )
     * 
     * @Serializer\Groups({"list", "card"})
     */
    protected $phone;
    
    /**
     * Статус.
     *
     * @ORM\Column(name="`status`", type="string", 
     *      columnDefinition="ENUM('Действующий', 'Потенциальный', 'Прошлый')", 
     *      nullable=false
     * )
     * 
     * @Assert\NotBlank(message = "Статус не может быть пустым")
     * @Assert\Choice(choices = {1, 2, 3},
     *      message = "Неверный статус. Допустимые статусы {1 : Действующий, 2 : Потенциальный, 3 : Прошлый}"
     * )
     * 
     * @Serializer\Groups({"list", "card"})
     */
    protected $status;
    
    /**
     * Документы прикрепленные к клиенту.
     * 
     * @ORM\OneToMany(targetEntity="Document", mappedBy="client")
     * 
     * @Serializer\Groups({"card"})
     * @Serializer\XmlList(inline = false, entry = "document")
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
     * Get fullname
     *
     * @return string ФИО.
     */
    public function getFullname() {
        return $this->fullname;
    }
    
    /**
     * Get email
     *
     * @return string Email.
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * Get phone
     *
     * @return string Телефон.
     */
    public function getPhone() {
        return $this->phone;
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
     * Get documents
     * 
     * @return \Doctrine\Common\Collections\Collection Документы прикрепленные к клиенту.
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
     * @return Client
     */
    public function setFullname($fullname) {
        $this->fullname = $fullname;

        return $this;
    }
    
    /**
     * Set email
     *
     * @param string $email Email.
     * @return Client
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }
 
    /**
     * Set phone
     *
     * @param string $phone Телефон.
     * @return Client
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }
  
    /**
     * Set status
     *
     * @param string $status Статус.
     * @return Client
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }
    
    #</editor-fold>
    
    #<editor-fold defaultstate="collapsed" desc="Add">
    
    /**
     * Add document
     * 
     * @param \AppBundle\Entity\Document $document Документ прикрепляемый к клиенту.
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
     * @param \AppBundle\Entity\Document $document Документ открепляемый от клиенту.
     */
    public function removeDocument(\AppBundle\Entity\Document $document) {
        $this->documents->removeElement($document);
    }
    
    #</editor-fold>

    #</editor-fold>
}
