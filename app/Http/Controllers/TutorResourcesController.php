<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TutorResourcesController extends Controller
{
   // main page for admin view in resources
   public function main()
   {
       return view('resources.tutor_resources');
   }

   public function pyq()
   {
       return view('resources.pyq_tutor');
   }

   public function textbook()
   {
       return view('resources.textbook_tutor');
   }

   public function module()
   {
       return view('resources.module_tutor');
   }

   
}
