<?php

namespace OpenCephalonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OpenCephalonBundle:Default:index.html.twig');
    }
}
