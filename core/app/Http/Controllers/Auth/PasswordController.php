<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Invoicer\Repositories\Contracts\SettingInterface as Settings;
use App\Invoicer\Repositories\Contracts\TemplateInterface as Templates;
use App\Invoicer\Repositories\Contracts\EmailSettingInterface as MailSetting;
use Illuminate\Support\Facades\Config;
use Laracasts\Flash\Flash;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

    /**
     * @var
     */

    protected $settings,$mail_setting;

    /**
     * @var
     */

    protected $templates;

    /**
     *  Create a new password controller instance.
     * @param Guard $auth
     * @param PasswordBroker $passwords
     * @param Settings $settings
     */


    public function __construct(Guard $auth, PasswordBroker $passwords, Settings $settings, Templates $template, MailSetting $mail_setting)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;
        $this->settings = $settings;
        $this->templates = $template;
        $this->mail_setting = $mail_setting;

		$this->middleware('guest');
	}
    public function postEmail(Request $request){
        $this->validate($request, ['email' => 'required']);
        $settings = $this->settings->first();
        $mail_setting = $this->mail_setting->first();
        if ($mail_setting) {
            if($mail_setting->protocol == 'smtp'){
                Config::set('mail.host', $mail_setting->smtp_host);
                Config::set('mail.username', $mail_setting->smtp_username);
                Config::set('mail.password', $mail_setting->smtp_password);
                Config::set('mail.port', $mail_setting->smtp_port);
            }
            try {
                $response = $this->passwords->sendResetLink($request->only('email'), function($message) use($settings,$mail_setting) {
                    $message->from($mail_setting ? $mail_setting->from_email : 'noreply@classicnvoicer.com', $mail_setting ? $mail_setting->from_name : 'Classic Invoicer');
                    $message->sender($mail_setting ? $mail_setting->from_email : 'noreply@classicnvoicer.com', $mail_setting ? $mail_setting->from_name : 'Classic Invoicer');
                    $message->subject(trans('application.password_reminder'));
                });
                switch ($response){
                    case PasswordBroker::RESET_LINK_SENT:
                        return redirect()->back()->with('status', trans($response));
                    case PasswordBroker::INVALID_USER:
                        return redirect()->back()->withErrors(['email' => trans($response)]);
                }
            } catch (\Exception $e) {
                Flash::error($e->getMessage());
                return redirect()->back();
            }
        } else {
            Flash::error(trans('application.email_settings_error'));
            return redirect()->back();
        }
    }
}
