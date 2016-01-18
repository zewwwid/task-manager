<?php

namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class DocumentToClientType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('client', EntityType::class,
                array('class' => 'AppBundle:Client', 'label' => 'Идентификатор клиента, к карточке которого добавляется новый документ'));
        $builder->add('administrator', EntityType::class,
                array('class' => 'AppBundle:Administrator', 'label' => 'Идентификатор администратора загружающего файл'));
        $builder->add('file', FileType::class, array('label' => 'Файл'));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document',
            'validation_groups' => 'DocumentToClient',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return "document";
    }

}
