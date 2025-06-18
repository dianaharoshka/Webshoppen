<?php

class Cart
{
    private $dbContext;
    private $session_id;
    private $cartItems = [];

    public function __construct($dbContext, $session_id)
    {
        $this->dbContext = $dbContext;
        $this->session_id = $session_id;
        $this->cartItems = $this->dbContext->getCartItemsBySession($session_id);
    }

    public function addItem($productId, $quantity)
    {
        $item = $this->getCartItem($productId);

        if (!$item) {
            $item = new CartItem();
            $item->productId = $productId;
            $item->quantity = $quantity;
            array_push($this->cartItems, $item);
        } else {
            $item->quantity += $quantity;
        }

        $this->dbContext->updateCartItemBySession($this->session_id, $productId, $item->quantity);
    }

    public function removeItem($productId, $quantity)
    {
        $item = $this->getCartItem($productId);
        if (!$item)
            return;

        $item->quantity -= $quantity;

        if ($item->quantity <= 0) {
            $this->dbContext->deleteCartItemBySession($this->session_id, $productId);
            $index = array_search($item, $this->cartItems);
            if ($index !== false) {
                array_splice($this->cartItems, $index, 1);
            }
        } else {
            $this->dbContext->updateCartItemBySession($this->session_id, $productId, $item->quantity);
        }
    }

    public function getCartItem($productId)
    {
        foreach ($this->cartItems as $item) {
            if ($item->productId == $productId) {
                return $item;
            }
        }
        return null;
    }

    public function getItemsCount()
    {
        $count = 0;
        foreach ($this->cartItems as $item) {
            $count += $item->quantity;
        }
        return $count;
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->cartItems as $item) {
            $total += $item->rowPrice;
        }
        return $total;
    }

    public function getItems()
    {
        return $this->cartItems;
    }

    public function clearCart()
    {
        $this->cartItems = [];
        $this->dbContext->clearCartBySession($this->session_id);
    }


}

?>