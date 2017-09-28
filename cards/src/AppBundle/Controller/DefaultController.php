<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        return $this->render('AppBundle:home:index.html.twig');
    }

    /**
     * @Route("/new", name="call")
     */
    public function call() {

        dump(file_get_contents('https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c'));

        return $this->render('AppBundle:home:show.html.twig');
    }
}
