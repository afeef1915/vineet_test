<?php

namespace Acme\Bundle\BitcoinBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Validator\Constraints\Date;
class AddNewRatesType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', 'text', array(
                    'label' => 'Email',
                    
                    'required' => true,
                ))
                ->add('phone_number', 'text', array(
                    'label' => 'Phone Number',
                    'required' => true,
                ))
                 ->add('buy_min', 'text', array(
                    'label' => 'Buy Min',
                    'required' => true,
                ))
                ->add('buy_max', 'text', array(
                    'label' => 'Buy Max',
                    'required' => true,
                ))
                 ->add('sell_min', 'text', array(
                    'label' => 'Sell Min',
                    'required' => true,
                ))
                 ->add('sell_max', 'text', array(
                    'label' => 'Sell Max',
                    'required' => true,
                ))
                 ->add('sell_max', 'text', array(
                    'label' => 'Sell Max',
                    'required' => true,
                ))
                
                ->add('save', 'submit')
                ->setMethod('POST')
                ->getForm()
        ;
//        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
//            $data = $event->getData();
//            $form = $event->getForm();
//
//        });
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
//        $resolver->setDefaults(array(
//            'taskDescription' => array(),
//            'attentionOf' => array(),
//            'category' => array()
//                //'dateCompleted'=>array()
//                //     'data_class' => 'WEBLOGS\MAIN\MTL\MyLogsBundle\Entity\VMyLogs'
//        ));
    }
    /**
     * @return string
     */
    public function getName() {
        return 'acmebundle_bitcoinbundle';
    }
}