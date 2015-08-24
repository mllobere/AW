<?php

namespace AWBundle\Resources\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\OptionsResolverInterface;

class CreateAwForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       /*$builder->add('awName', 'text', array('label' => 'Name'));
       $builder->add('awPlace', 'text', array('label' => 'Place'));
       $builder->add('awDate', 'date', array('label' => 'Date'));
       $builder->add('awSave', 'submit', array('label' => 'Create'));         */
       $builder->add('aw');
    }


    public function getName()
    {
        return 'awCreate';
    }
}
