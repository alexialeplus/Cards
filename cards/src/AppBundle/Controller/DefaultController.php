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
     * Render the homepage
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        return $this->render('AppBundle:home:index.html.twig');
    }

    /**
     * Call the API and get the results back
     * @Route("/new", name="call")
     */
    public function call() {

        $results = file_get_contents('https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c');
        $results = json_decode($results, true);
        $results = $results['data'];

        $sortedCards = $this->sort($results['categoryOrder'], $results['valueOrder'], $results['cards']);


        return $this->render('AppBundle:home:show.html.twig', array(
            'cards' => $sortedCards,
            )
        );
    }

    /*
     * Sort cards according the sorting given by the API
    */
    public function sort($categories, $values, $cards) {

        if (isset($categories) && isset($values) && isset($cards) && is_array($categories) && is_array($values) && is_array($cards))
        {
            $sortedCards = array();

            foreach ($categories as $category) {
                foreach ($values as $value) {
                    foreach ($cards as $card) {
                        if ($card["category"] === $category && $card["value"] === $value)
                        {
                            array_push($sortedCards, $card);
                            unset($cards[$category][$value]);
                        }
                    }
                }
            }

            return $sortedCards;
        }
    }
}
