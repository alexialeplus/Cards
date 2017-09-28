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

        $results = file_get_contents('https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c');
        $results = json_decode($results, true);
        $results = $results['data'];

        $sortedCards = $this->tri($results['categoryOrder'], $results['valueOrder'], $results['cards']);


        return $this->render('AppBundle:home:show.html.twig', array(
            'categories' => $results['categoryOrder'],
            'values' => $results['valueOrder'],
            'cards' => $sortedCards,
            )
        );
    }

    public function tri($categories, $values, $cards) {
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
