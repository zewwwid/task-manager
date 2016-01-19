<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;

/**
 * Документ.
 * 
 * @ORM\Entity
 * @ORM\Table(name="documents")
 * @ORM\HasLifecycleCallbacks
 * 
 * @Serializer\XmlRoot("document")
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

    /**
     * @Assert\NotBlank(groups={"DocumentToClient"}, 
     *      message = "Необходимо выбрать файл"
     * )
     * @Assert\File(groups={"DocumentToClient"}, maxSize = "1M")
     */
    public $file;
    
    /**
     * Задача к которой прикреплен документ.
     * 
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="documents")
     * @ORM\JoinColumn(name="task", referencedColumnName="id")
     * */
    protected $task;

    /**
     * Клиент к которому прикреплен документ.
     * 
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="documents")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     * 
     * @Assert\NotBlank(groups={"DocumentToClient"}, 
     *      message = "Клиент не может быть пустым"
     * )
     * */
    protected $client;

    /**
     * Администратор загрузивший документ.
     * 
     * @ORM\ManyToOne(targetEntity="Administrator", inversedBy="documents")
     * @ORM\JoinColumn(name="administrator", referencedColumnName="id")
     * 
     * @Assert\NotBlank(groups={"DocumentToClient"}, 
     *      message = "Администратор не может быть пустым"
     * )
     * */
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
    public function getTask() {
        return $this->task;
    }

    /**
     * Get client
     * 
     * @return \AppBundle\Entity\Client Клиент к которому прикреплен документ.
     */
    public function getClient() {
        return $this->client;
    }

    /**
     * Get administrator
     * 
     * @return \AppBundle\Entity\Administrator Администратор загрузивший документ.
     */
    public function getAdministrator() {
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

    #<editor-fold defaultstate="collapsed" desc="Upload">
    
    /**
     * Возвращает относительный путь до директории, в которую производится 
     * загрузка файлов документа.
     * 
     * @return string
     */
    protected function getUploadDir() {
        return 'uploads/documents';
    }

    /**
     * Возвращает абсолютный путь до директории, в которую производится 
     * загрузка файла для текущего документа.
     * 
     * @return string
     */
    public function getAbsolutePath() {
        return $this->getUploadRootDir() . '/' . $this->id . '/';
    }

    /**
     * Возвращает абсолютный путь до директории, в которую производится 
     * загрузка файлов документов.
     * 
     * @return string
     */
    protected function getUploadRootDir() {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    /**
     * Устанавливает имя загружаемого файла.
     * Вызывается перед созданием/обновлением документа.
     * 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if ($this->file !== null) {
            $this->setFilename($this->file->getClientOriginalName());
        }
    }

    /**
     * Загружает файл.
     * Вызывается после создания/обновления документа.
     * 
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if ($this->file !== null) {
            $this->file->move($this->getAbsolutePath(),
                    $this->file->getClientOriginalName());

            unset($this->file);
        }
    }
    
    #</editor-fold>
    
    #</editor-fold>

}
