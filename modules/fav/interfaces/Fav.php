<?php
namespace app\modules\fav\interfaces;

interface Fav
{
    public function my();
    
    public function put(Element $model);
    
    public function getElements();
    
    public function getElement(FavElement $model);
    
    public function getCost();
    
    public function getCount();
    
    public function getElementById($id);
    
    public function getElementsByModel(FavElement $model);
    
    public function truncate();
}