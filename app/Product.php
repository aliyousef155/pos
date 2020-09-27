<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['name','description'];
    protected $guarded=[];
    protected $appends=['image_path','profit_percent'];
    public function category(){
    return $this->belongsTo(category::class);
    }// end of function
    public function getImagePathAttribute(){
        return asset('uploads/products_images/'.$this->image);
    }//end of path
    public  function getProfitPercentAttribute(){
        $profit=$this->sale_price- $this->purchase_price;
        $profit_percent=$profit *100/$this->purchase_price;
        return $profit_percent;
    }//end of profit percent
    public function orders(){
        return $this->belongsToMany(Order::class,'product_order');
    }

}// end of model
