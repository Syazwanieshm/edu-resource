<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentResourcesController extends Controller
{
   // main page for admin view in resources
   public function main()
   {
       return view('resources.stud_resources');
   }

   public function pyq()
   {
       return view('resources.pyq_stud');
   }

   public function textbook()
   {
       return view('resources.textbook_stud');
   }

   public function module()
   {
       return view('resources.module_stud');
   }

   
}