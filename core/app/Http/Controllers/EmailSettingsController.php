<?php namespace App\Http\Controllers;

use App\Http\Requests\EmailSettingsRequest;
use App\Invoicer\Repositories\Contracts\EmailSettingInterface as Setting;
use Config;
use Laracasts\Flash\Flash;

class EmailSettingsController extends Controller {

	private $setting;

	public function __construct(Setting $setting){
		$this->setting = $setting;
        $this->middleware('permission:edit_setting');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$setting = $this->setting->count() > 0 ? $this->setting->first() : array();
		return view('settings.email.index', compact('setting'));
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EmailSettingsRequest $request)
	{
		$data =  array(
			'protocol'		=>$request->protocol,
			'smtp_host' 	=>$request->smtp_host,
			'smtp_username' =>$request->smtp_username,
			'smtp_password' =>$request->smtp_password,
			'smtp_port' 	=>$request->smtp_port,
			'from_email' 	=>$request->from_email,
			'mailgun_domain' 	=>$request->mailgun_domain,
			'mailgun_secret' 	=>$request->mailgun_secret,
			'mandrill_secret' 	=>$request->mandrill_secret,
			'from_name' 	    =>$request->from_name,
		);
		if($this->setting->create($data)){
            Config::write('services.mailgun', [
                'domain'=>$request->mailgun_domain,
                'secret'=>$request->mailgun_secret,
            ]);
            Config::write('services.mandrill', [
                'secret'=>$request->mandrill_secret,
            ]);
            Config::write('mail.from', [
                'address'=>$request->from_email,
                'name'=>$request->from_name,
            ]);
            //Edit config mail.php file and add new database details
            $template_path 	= base_path().'/.env';
            $config_file = file_get_contents($template_path);
            $new  = str_replace("%MAIL_DRIVER%",$request->protocol,$config_file);
            file_put_contents(base_path().'/.env', $new);
			Flash::success(trans('application.record_updated'));
		}
		else{
			Flash::error(trans('application.update_failed'));
		}
		return redirect('settings/email');
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EmailSettingsRequest $request, $uuid)
	{
		$data =  array(
			'protocol'		=>$request->protocol,
			'smtp_host' 	=>$request->smtp_host,
			'smtp_username' =>$request->smtp_username,
			'smtp_password' =>$request->smtp_password,
			'smtp_port' 	=>$request->smtp_port,
			'from_email' 	=>$request->from_email,
            'mailgun_domain' 	=>$request->mailgun_domain,
            'mailgun_secret' 	=>$request->mailgun_secret,
            'mandrill_secret' 	=>$request->mandrill_secret,
            'from_name' 	    =>$request->from_name,
		);

		if($this->setting->updateById($uuid, $data)){
            Config::write('services.mailgun', [
                'domain'=>$request->mailgun_domain,
                'secret'=>$request->mailgun_secret,
            ]);
            Config::write('services.mandrill', [
                'secret'=>$request->mandrill_secret,
            ]);
            Config::write('mail.from', [
                'address'=>$request->from_email,
                'name'=>$request->from_name,
            ]);
            //Edit config mail.php file and add new database details
            $template_path 	= base_path().'/.env';
            $config_file = file_get_contents($template_path);
            $new  = str_replace("%MAIL_DRIVER%",$request->protocol,$config_file);
            file_put_contents(base_path().'/.env', $new);
			Flash::success(trans('application.record_updated'));
		}
		else{
			Flash::error(trans('application.update_failed'));
		}
		return redirect('settings/email');
	}
}
