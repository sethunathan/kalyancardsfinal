<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Posts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function getImagesfile()
{
    //public/uploads/photo1.jpg
    //public/uploads/photo2.jpg
    
    $path = base_path('uploads/thumbnail');
    $files = File::files($path);//  $files = \File::files(base_path('uploads')); 
    if (!File::exists($path)) {
            return response()->json(['error' => 'Uploads folder not found'], 404);
        }
    $images = [];
    foreach ($files as $file) {
        $images[] = [
            'name' => $file->getFilename(),
            'url'  => asset('uploads/thumbnail/'.$file->getFilename()),
        ];
    }
    //'url' => asset('uploads/thumbnail/'.$file->getFilename()), url('uploads/thumbnail/'.$file->getFilename()),

    return response()->json($images);
}

  public function getImages()
{
    //public/uploads/photo1.jpg
    //public/uploads/photo2.jpg
    
   // $path = base_path('uploads/thumbnail');
    //$files = File::files($path);//  $files = \File::files(base_path('uploads')); 
    //if (!File::exists($path)) {
      //      return response()->json(['error' => 'Uploads folder not found'], 404);
       // }
    //$images = [];
    //foreach ($files as $file) {
       // $images[] = [
       //     'name' => $file->getFilename(),
         //   'url'  => asset('uploads/thumbnail/'.$file->getFilename()),
       // ];


        $posts = Posts::all(); 
        $data = $posts->map(function($post) {
            return [
                'id'      => $post->id,
                'title'   => $post->title,
                'thumb_url' => $post->thumb_url,
                'thumbnail' => asset('uploads/thumbnail/'.$post->thumb_url), // ✅ thumbnail URL
                'image'     => asset('uploads/posts/'.$post->item_url),    
            ];
        });
           // $path = base_path('uploads/posts/'.$filename);
        return response()->json($data);

    }
    //'url' => asset('uploads/thumbnail/'.$file->getFilename()), url('uploads/thumbnail/'.$file->getFilename()),

   // return response()->json($images);
//}

      public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

      public function registerolld(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

     public function loginn(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user]);
    }

    
    public function profile(Request $request) {
        return $request->user();
    }
    
    function Registerold(Request $R)
    {
        try {
            $cred = new User();
            $cred->name = $R->name;
            $cred->email = $R->email;
            $cred->password = Hash::make($R->password);
            $cred->save();
            $response = ['status' => 200, 'message' => 'Register Successfully! Welcome to Our Community'];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e];
        }
    }

    function Loginnold(Request $R){
        $user = User::where('email', $R->email)->first();

        if($user!='[]' && Hash::check($R->password,$user->password)){
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['status' => 200, 'token' => $token, 'user' => $user, 'message' => 'Successfully Login! Welcome Back'];
            return response()->json($response);
        }else if($user=='[]'){
            $response = ['status' => 500, 'message' => 'No account found with this email'];
            return response()->json($response);

        }else{
            $response = ['status' => 500, 'message' => 'Wrong email or password! please try again'];
            return response()->json($response); 
        } 
    }
      
    function getPostsbyPage(Request $request){
        
        $posts = Posts::where('status','0'); 
        $posts->orderBy('id','DESC'); 
        $posts = $posts->get(); 
       // if(count($posts) > 0 && $post_type != "greeting" && $type != "subcategory"){
        //    $out['subcategories'] = SubCategory::where('category_id',$posts[0]["category_id"])->where('status','0')->get();
       // }  
      //  $out['userFrames'] = UserFrame::where('user_id',$user_id)->orderBy('id','DESC')->get();
        
        $out['code'] = 200;
        $out['message'] = "Success";
        $out['posts'] = $posts;
        
        return response()->json($out);
    }
   
     
}

?>