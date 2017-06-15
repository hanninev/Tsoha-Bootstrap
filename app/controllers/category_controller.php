<?php

  class CategoryController extends BaseController{

    public static function list(){
      View::make('category/list.html');
    }

    public static function edit(){
      View::make('category/edit.html');
    }

    public static function add(){
      View::make('category/add.html');
    }
  }