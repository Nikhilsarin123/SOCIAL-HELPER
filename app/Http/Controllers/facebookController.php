<?php

namespace App\Http\Controllers;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class facebookController extends Controller
{
 
          public function logineer()
          {
              	$facebook = new Facebook(array(
   
               'appId' => '597521067856985',
               'secret' => 'e5a1211359d2d38cb75b71befdf13e3c',
           ));

    if($facebook->getUser() ==0)
    {
	$login = $facebook->getLoginUrl();
	echo "<a href ='$login'>Login with facebook</a>";

    } 
   else
    { 
	echo "you are login using the faceboook";

   }
          }
   //
}
