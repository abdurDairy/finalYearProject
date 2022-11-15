<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\navigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class navController extends Controller
{
    //**NAVIGATION  */
    public function backEndNav(){
        $allInfoNav = navigation::latest()->get();
        return view('BackEnd.nav',compact('allInfoNav'));
    }


    //****NAVE DATA INSERT IN DATABASE */
    public function navInsert(Request $navRequest){

        //**NAVIGATIN INSERTION VALIDATE** */
        $navRequest->validate([
            'navLogoImage'=>'required',
            'navPhoneNumber'=>'required',
            'navAddress'=>'required'
        ]);

        // **IMAGE CUTTING
        // $extension = $navRequest->navLogoImage->extension();
        // $imageName = 'navigationImage-'.$navRequest->navPhoneNumber.'.' . $extension;
        // $imagePath = $navRequest->navLogoImage->storeAs('navImage/',$imageName,'public');
        // $imageUrl = env('APP_URL') . '/storage/' . $imagePath;
        $imageRefactedData = $this->imageRefactorig($navRequest);

        // **requested data inserted in datbase**
        $nav = new navigation();
        // $nav->nav_image = $imageRefactedData['imageUrl'];
        // $nav->nav_phone = $navRequest->navPhoneNumber;
        // $nav->nav_address = $navRequest->navAddress;
        // $nav->save();
        $this->dataStoreRefactoring($nav,$navRequest,$imageRefactedData);
        return redirect()->route('backend.nav')->with('success', 'nav info inserted in DB');
    }

    // ** NAV EDIT
    public function navEdit(navigation $navEdit){
        $allInfoNav = navigation::all();
        return view('BackEnd.nav',compact('allInfoNav','navEdit'));
    }


    //**IMAGE REFACTORING */
    public function imageRefactorig($navRequest){
        $extension = $navRequest->navLogoImage->extension();
        $imageName = 'navigationImage-'.uniqid().'.' . $extension;
        $imagePath = $navRequest->navLogoImage->storeAs('navImage/',$imageName,'public');
        $imageUrl = env('APP_URL') . '/storage/' . $imagePath;
        return ['imageName'=>$imageName,'imageUrl'=>$imageUrl];
    }


    // *****DATA STORE REFACTORING ****
    public function dataStoreRefactoring($nav,$navRequest,$imageRefactedData = null ){
        if($navRequest->hasFile('navLogoImage')){
            $nav->nav_image = $imageRefactedData['imageUrl'];
        }
        $nav->nav_phone = $navRequest->navPhoneNumber;
        $nav->nav_address = $navRequest->navAddress;
        $nav->save();
    }

    //*** NAVIGATION UPDATE *****/
    public function navUpdate(Request $navRequest, navigation $navigation){

        // *** CREATE PATH FOR CHECKING EXISTING IMAGE IN STORAGR FOLDER***
        $path = 'navigation/'. $navigation->navLogoImage;
        if($navRequest->hasFile('navLogoImage')){
            // IF EXISTING IMAGE FOUND, THEN DELETE IT
            //  if(Storage::disk('public')->exists($path)){
            //     Storage::disk('public')->delete($path);
            //  }
            $this->imageDeleteRefactorig($path);
             $imageRefactedData = $this->imageRefactorig($navRequest);
             $this->dataStoreRefactoring($navigation,$navRequest,$imageRefactedData);
             return redirect()->route('backend.nav')->with('success','updated your image');
        }else{
            $this->dataStoreRefactoring($navigation,$navRequest);
            return redirect()->route('backend.nav')->with('success','updated data');
        }
    }


    // ** IMAGE DELETE REFACTORING 
    public function imageDeleteRefactorig($path){
        if(Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
         }
         return true;
    }


    // *** DELETE NAVIGATION ***
    public function navDelete(navigation $navigation){
      $isDelete =  $this->imageDeleteRefactorig($navigation);
       if($isDelete){
         $navigation->delete();
       }
       return redirect()->route('backend.nav')->with('delete','your navigation data deleted');
    }
}