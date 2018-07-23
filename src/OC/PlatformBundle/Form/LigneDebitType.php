<?php
namespace OC\PlatformBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;

class LigneDebitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('isDebit', ChoiceType::class, array(
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                true => 'true',
                false => 'false'
            ),
            'data' => 'true'
        ));
    }
    
    public function getParent()
    {
        return LigneCompteType::class;
    }
}