<?php

  class OrderController extends BaseController{

    public static function inbox(){
      View::make('arrivedOrders.html');
    }

    public static function show(){
      View::make('order-show.html');
    }

    public static function edit(){
      View::make('order-edit.html');
    }

    public static function myOrders(){
      View::make('myOrders.html');
    }

    public static function cart(){
      View::make('cart.html');
    }
  }
