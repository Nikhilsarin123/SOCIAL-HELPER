<?php

namespace App\Http\Controllers;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Illuminate\Support\Facades\View;
use Facebook\FacebookRequestException;
 
class GraphController extends Controller
{

	 private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->token);
            $this->api = $fb;
            return $next($request);
        });
    }
 
    public function retrieveUserProfile($user_id){
         $data=$user_id;
        try {
            $params = "first_name,last_name,age_range,gender";
 
            $user = $this->api->get('/me?fields='.$params)->getGraphUser();
 
                             
           return view("admin",compact('data'));
 
        } catch (FacebookSDKException $e) {
 
        }
    }

    public function getPageAccessToken($page_id){
    try {
         // Get the \Facebook\GraphNodes\GraphUser object for the current user.
         // If you provided a 'default_access_token', the '{access-token}' is optional.
         $response = $this->api->get('/me/accounts', Auth::user()->token);
    } catch(FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
 
    try {
        $pages = $response->getGraphEdge()->asArray();
        foreach ($pages as $key) {
            if ($key['id'] == $page_id) {
                return $key['access_token'];
            }
        }
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}

  public function publishToProfile(Request $request){

    try {
        $response = $this->api->post('/me/feed', [
            'message' => $request->message
        ])->getGraphNode()->asArray();
        if($response['id']){
           // post created
        }
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
  }
public function publishToPage(Request $request){

    $sec=00;
    $timer= strtotime($request->date. ' ' .$request->time.':'.$sec);
 
    $page_id = $request->page_id;
 
    try {
        $post = $this->api->post('/' . $page_id . '/feed', array('message' => $request->message,
       'scheduled_publish_time' => $timer,
          'published' => false,
        ), $this->getPageAccessToken($page_id));
 
        $post = $post->getGraphNode()->asArray();
        return view('admin')->with('success','post added you can add more');
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}

public function publishPhotoToPage(Request $request){

    
   
 
    $page_id = $request->page_id;
 
    try {
        $post = $this->api->post('/' . $page_id . '/photos', array('caption' => $request->message, 'url'=>'https://www.facebook.com/images/fb_icon_325x325.png','published'=>false),
         $this->getPageAccessToken($page_id));
 
        $post = $post->getGraphNode()->asArray();
        return view('admin')->with('success','post added you can add more');
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}
public function publishVideoToPage(Request $request){


 
    $page_id = $request->page_id;
 
    try {
        $post = $this->api->post('/' . $page_id . '/videos', array('message' => $request->message,'url'=>$request->video
        ), $this->getPageAccessToken($page_id));
 
        $post = $post->getGraphNode()->asArray();
        return view('admin')->with('success','post added you can add more');
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}
public function publishLinkToPage(Request $request){

 
 
    $page_id = $request->page_id;
 
    try {
        $post = $this->api->post('/' . $page_id . '/feed', array('message' => $request->message,'link'=>$request->url
        ), $this->getPageAccessToken($page_id));
 
        $post = $post->getGraphNode()->asArray();
        return view('admin')->with('success','post added you can add more');
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}
public function publishTogroup(Request $request){

   
    $groupid = $request->group_id;
    try {
        $post = $this->api->post('/' . $groupid . '/feed', array('message' => $request->message), $this->getPageAccessToken($groupid));

        $post = $post->getGraphNode()->asArray();
        return view("admin")->with('success','post added');
 
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}

public function publishPhotoTogroup(Request $request){

   
    $groupid = $request->group_id;
    try {
        $post = $this->api->post('/' . $groupid . '/photos', array('caption' => $request->message,'url'=>'https://www.facebook.com/images/fb_icon_325x325.png','published'=>false)), $this->getPageAccessToken($groupid));

        $post = $post->getGraphNode()->asArray();
        return view("admin")->with('success','post added');
 
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}

public function publishLinkTogroup(Request $request){

   
    $groupid = $request->group_id;
    try {
        $post = $this->api->post('/' . $groupid . '/feed', array('message' => $request->message,'link'=>$request->link), $this->getPageAccessToken($groupid));

        $post = $post->getGraphNode()->asArray();
        return view("admin")->with('success','post added');
 
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}

public function publishVideoTogroup(Request $request)

{

   
    $groupid = $request->group_id;
    try {
        $post = $this->api->post('/' . $groupid . '/videos', array('url' => $request->image,'caption'=>$request->message,), $this->getPageAccessToken($groupid));

        $post = $post->getGraphNode()->asArray();
        return view("admin")->with('success','post added');
 
        dd($post);
 
    } catch (FacebookSDKException $e) {
        dd($e); // handle exception
    }
}

public function Getpages($id){
  
 try {
  // Returns a `Facebook\FacebookResponse` object
   $pages = $this->api->get('/me/accounts', Auth::user()->token)->getGraphEdge()->asArray();
$items = collect($pages);
 $items_name = $items->pluck('id','name');
 if($id == 1)
 {
   return view("main_admin.pages.createpage",compact('items_name'));
 }
 if ($id==2) {

    return view("main_admin.pages.postlink",compact('items_name'));
    
 }
 if ($id ==3) {
    return view("main_admin.pages.postphoto",compact('items_name'));
}
if($id == 4)
{
    return view("main_admin.pages.postvideo",compact('items_name'));
    # code...
}
if($id == 5)
{
    return view("main_admin.actives.showpagesposts",compact('items_name'));
    # code...
}

if($id == 6)
{
    return view("main_admin.actives.mypages
        ",compact('items_name'));
    # code...
}
}
catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
}
 catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
} 


public function Getgroups($id){
   
    try {
  // Returns a `Facebook\FacebookResponse` object
   $group = $this->api->get('/me/groups', Auth::user()->token)->getGraphEdge()->asArray();
$items = collect($group);
  $items_name = $items->pluck('name','id');
  
   if($id == 1)
 {
   return view("main_admin.pages.createpage",compact('items_name'));
 }
 if ($id==2) {

    return view("main_admin.group.postlink",compact('items_name'));
    
 }
 if ($id ==3) {
    return view("main_admin.group.postphoto",compact('items_name'));
}
if($id == 4)
{
    return view("main_admin.group.postvideo",compact('items_name'));
    # code...
}

if($id == 5)
{
    return view("main_admin.actives.showgrouppost",compact('items_name'));
    # code...
}
if($id == 6)
{
    return view("main_admin.actives.mygroup",compact('items_name'));
    # code...
}
}
catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} 
catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
}
public function activepagefeed(Request $request){
    try {
  // Returns a `Facebook\FacebookResponse` object
        $page_id=$request->page_id;
   $pagefeed = $this->api->get('/'.$request->page_id.'/feed', $this->getPageAccessToken($page_id))->getGraphEdge()->asArray();
$items = collect($pagefeed);
  $items_name = $items->pluck('id','message');
   return view("main_admin.actives.ppostlist",compact('items_name'));

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
}

public function deleteppost($id){

    dd($id);
   
    try {
  // Returns a `Facebook\FacebookResponse` object
     
     $this->api->delete('/'.$id, array (),$this->getPageAccessToken($id))->getGraphEdge()->asArray();

   dd(done);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
}

public function activegroupfeed(Request $request){

    try {
  // Returns a `Facebook\FacebookResponse` object
   $feed = $this->api->get('/'.$request->group_id.'/feed', $this->getPageAccessToken($request->group_id))->getGraphEdge()->asArray();
$items = collect($feed);

  $items_name = $items->pluck('message','id');
   return view("main_admin.actives.gpostlist",compact('items_name'));

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
}

public function allpost(){
    try {
  // Returns a `Facebook\FacebookResponse` object
   $group = $this->api->get('/me/groups', Auth::user()->token)->getGraphEdge()->asArray();
$items = collect($group);
  $items_name = $items->pluck('name','id');
   return view("main_admin.pages.create",compact('items_name'));

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
}
public function allpages(){
    try {
  // Returns a `Facebook\FacebookResponse` object
   $group = $this->api->get('/me/groups', Auth::user()->token)->getGraphEdge()->asArray();
$items = collect($group);
  $items_name = $items->pluck('name','id');
   return view("main_admin.pages.create",compact('items_name'));

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
}


    //
}

