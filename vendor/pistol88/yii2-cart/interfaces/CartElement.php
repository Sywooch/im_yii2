<?php
namespace pistol88\cart\interfaces;

interface CartElement
{
    public function getCartId();	
	public function getCartThumb();
    public function getCartName();	
	public function getCartSku();	
	public function getCartCode();	
	public function getCartAlias();
    public function getCartPrice();	
	public function getCartOldPrice();  
    public function getCartOptions();
}
