<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Cart;
use App\Entity\Item;
use App\Entity\Country;

use App\Form\CartNewType;

class CartController extends AbstractController
{
    public function index() {
        return $this->render('cart/index.html.twig');
    }

    public function new(Request $request) {

        $cart = new Cart();
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();
        $item4 = new Item();
        $item5 = new Item();

        $cart->addItem($item1)
            ->addItem($item2)
            ->addItem($item3)
            ->addItem($item4)
            ->addItem($item5);

        $form = $this->createForm(CartNewType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $this->addFlash('success', 'Form Valid :)');
                return $this->redirectToRoute('index');
            }
            else {
                $this->addFlash('danger', 'Form Error');
            }
        }

        return $this->render('cart/new.html.twig', 
            [
                'form' => $form->createView()
            ]
        );
    }


}