<?php

namespace OpenCephalonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ItemNewType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('title', 'text', array(
            'required' => true,
            'label'=>'Title'
        ));

        $builder->add('description', 'textarea', array(
            'required' => true,
            'label'=>'Description'
        ));

        $builder->add('url', 'url', array(
            'required' => true,
            'label'=>'URL'
        ));

    }

    public function getName() {
        return 'tree';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'OpenCephalonBundle\Entity\Item',
        );
    }
}
