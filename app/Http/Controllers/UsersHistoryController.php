<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use PDF;
use DB;

class UsersHistoryController extends Controller
{
    function index()
    {
     $users = $this->get_user_data();
     return view('usershistory.mypdf')->with('users', $users);
    }

    function get_user_data()
    {
     $users = DB::table('users')
         ->limit(10)
         ->get();
     return $users;
    }

    function pdf()
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_user_data_to_html());
     return $pdf->stream();
    }

    function convert_user_data_to_html()
    {
     $users = $this->get_user_data();
     $output = '
     <h3 align="center">Customer Data</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:12px;" width="20%">Name</th>
    <th style="border: 1px solid; padding:12px;" width="30%">Email</th>
    <th style="border: 1px solid; padding:12px;" width="15%">Role</th>
    <th style="border: 1px solid; padding:12px;" width="15%">Ip Address</th>
    <th style="border: 1px solid; padding:12px;" width="20%">Number of logins</th>
   </tr>
     ';  
     foreach($users as $user)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$user->name.'</td>
       <td style="border: 1px solid; padding:12px;">'.$user->email.'</td>
       <td style="border: 1px solid; padding:12px;">'.$user->role.'</td>
       <td style="border: 1px solid; padding:12px;">'.$user->ip_address.'</td>
       <td style="border: 1px solid; padding:12px;">'.$user->number_of_logins.'</td>
      </tr>
      ';
     }
     $output .= '</table>';
     return $output;
    }   
}
