<?php
namespace app\modules\fav\interfaces;

interface FavElement
{
    public function getFavId();	
	public function getFavThumb();
    public function getFavName();	
	public function getFavSku();	
	public function getFavCode();	
	public function getFavAlias();
    public function getFavPrice();	
	public function getFavOldPrice();
}
