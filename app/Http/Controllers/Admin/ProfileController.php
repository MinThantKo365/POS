<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //change password page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }

    //change password
    public function changePasswordPost(Request $request)
    {
        // must be validate
        $this->passwordRequest($request);
        $currentLoginPwd = Auth::user()->password;
        if(Hash::check($request->oldPassword, $currentLoginPwd)){
        // password change
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            Alert::success('Password Changed', 'Password Changed Successful!!!');
            return to_route('AdminHome');
        }else{
            Alert::error('Password Changed Fail', 'Old Password was not correct!!');
            return back();
        }

    }

    //direct profile
    public function ProfilePage(){
        return view('admin.profile.profilePage');
    }

    private function passwordRequest($request)
    {
        //newPassword = confirmPassword
         $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword|min:6',
        ]);
    }
}
