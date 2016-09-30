<?php

namespace OpenCephalonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class OutStreamNewType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('title', 'text', array(
            'required' => true,
            'label'=>'Title'
        ));

        // TODO enforce slug like!
        $builder->add('publicId', 'text', array(
            'required' => true,
            'label'=>'Key'
        ));

    }

    public function getName() {
        return 'tree';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'OpenCephalonBundle\Entity\OutStream',
        );
    }
}
