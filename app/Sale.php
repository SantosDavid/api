<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];

    public function vendor()
    {
    	return $this->hasMany('App\Vendor');
    }

    public function listSales()
    {
        return $this->all();
    }

    public function insert($request)
    {
        $request['comission'] = $request['price'] * 0.085;

        $sale = $this->create($request);

        return $this->informationVendor($sale->attributes['id']);
    }

    public function informationVendor($idSale)
    {
        return $this->join('vendors', 'vendors.id', '=', 'sales.id_vendor')
                    ->where('sales.id', $idSale)
                    ->select('vendors.name', 'vendors.email', 'sales.price', 'sales.comission')
                    ->get();
    }
}