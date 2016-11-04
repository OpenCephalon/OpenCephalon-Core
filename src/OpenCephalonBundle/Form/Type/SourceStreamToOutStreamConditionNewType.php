<?php

namespace OpenCephalonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class SourceStreamToOutStreamConditionNewType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options) {


        // Currently 'required' => true cos only one field, when more than one field should be false
        $builder->add('contains', 'text', array(
            'required' => true,
            'label'=>'Contains'
        ));

    }

    public function getName() {
        return 'tree';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition',
        );
    }
}
