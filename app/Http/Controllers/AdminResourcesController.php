<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminResourcesController extends Controller
{
   // main page for admin view in resources
   public function main()
   {
       return view('resources.admin_resources');
   }

   public function pyq()
   {
       return view('resources.pyq_admin');
   }

   public function textbook()
   {
       return view('resources.textbook_admin');
   }

   public function module()
   {
       return view('resources.module_admin');
   }

   public function tips()
   {
       return view('resources.tips_admin');
   }
}
