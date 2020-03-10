<?php namespace App\Http\Controllers\ClientArea;

use App\Http\Requests\ClientProfileFormRequest;
use App\Invoicer\Repositories\Contracts\ClientInterface as Profile;

class ProfileController extends Controller {
    private $profile;

    public function __construct(Profile $profile){
        $this->profile = $profile;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit()
	{
        if (auth()->guard('user')->user())
        {
            $user = $this->profile->getById(auth()->guard('user')->user()->uuid);
            return view('clientarea.users.profile', compact('user'));
        }
        return redirect('clientarea/cprofile');
	}

    /**
     * @param ClientProfileFormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ClientProfileFormRequest $request){
        if (auth()->guard('user')->user()){
            $user = $this->profile->getById(auth()->guard('user')->user()->uuid);
            $data =  array(
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'website' => $request->website,
                'notes' => $request->notes,
            );
            if ($request->hasFile('photo')){
                $file = $request->file('photo');
                $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
                $file->move('assets/img/uploads/client_images', $filename);
                \Image::make(sprintf('assets/img/uploads/client_images/%s', $filename))->resize(200, 200)->save();
                \File::delete('assets/img/uploads/client_images/'.$user->photo);
                $data['photo']= $filename;
            }
            if($request->get('password') != ''){
                $data['password']= bcrypt($request->password);
            }
            $this->profile->updateById($user->uuid, $data);
            flash()->success('Profile updated');
            return redirect('clientarea/cprofile');
        }
	}
}
