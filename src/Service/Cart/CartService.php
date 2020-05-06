<?php 

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $pr)
    {
        $this->session = $session;
        $this->productRepository = $pr;
    }

    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);  

        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function removeOneItem($id)
    {
        $panier = $this->session->get('panier', []);  

        if(!empty($panier[$id])){
            $panier[$id]--;
        }
        elseif(empty($panier[$id])) {
            unset($panier[$id]);
        }
        
        
        $this->session->set('panier', $panier);
    }

    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);  

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

     public function getFullPanier()
     {
        $panier = $this->session->get('panier', []);

        $panierData = [];

        foreach($panier as $id => $quantity){
            $panierData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity,
            ];
        }

      
        return $panierData;
     }

    public function getTotal()
    {

        $total = 0;

        foreach($this->getFullPanier() as $item){
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $total;
    }
}