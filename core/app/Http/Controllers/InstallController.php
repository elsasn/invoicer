<?php namespace App\Http\Controllers;
use App\Http\Requests\InstallRequest;
use App\Http\Requests\InstallUserRequest;
use App\Invoicer\Repositories\Contracts\UserInterface as User;
use App\Invoicer\Repositories\Contracts\RoleInterface as Role;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Flash;
use Response;

class InstallController extends Controller {
    /**
     * @var
     */
    protected $user, $role, $setting;
    /**
     * @param User $user
     */
    public function __construct(User $user, Role $role, Setting $setting){
        $this->user = $user;
        $this->role = $role;
        $this->setting = $setting;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('install.requirements');
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getDatabase()
	{
        return view('install.database');
	}
    /**
     * Store a newly created resource in storage.
     * @param InstallRequest $request
     * @return string
     */
    public function postDatabase(InstallRequest $request)
	{
        // Connect to the database
        try
        {
            $pdo = new \PDO("mysql:host=".$request->get('hostname'),$request->get('username'),$request->get('password'));
            //Create Database if not already created
            $pdo->exec("CREATE DATABASE IF NOT EXISTS ".$request->get('database'));

            $options = [
                'host'=>$request->get('hostname'),
                'database'=>$request->get('database'),
                'username'=>$request->get('username'),
                'password'=>$request->get('password'),
                ];
            $default = Config::get("database.connections.mysql");

            // Loop through our default array and update options if we have non-defaults
            foreach($default as $item => $value)
            {
                $default[$item] = isset($options[$item]) ? $options[$item] : $default[$item];
            }
            // Set the temporary configuration
            Config::set("database.connections.mysql", $default);

            //Edit config database.php file and add new database details
            $template_path 	= base_path().'/.env.example';

            // Open the file
            $database_file = file_get_contents($template_path);
            $new  = str_replace("%DB_HOST%",$request->get('hostname'),$database_file);
            $new  = str_replace("%DB_DATABASE%",$request->get('database'),$new);
            $new  = str_replace("%DB_USERNAME%",$request->get('username'),$new);
            $new  = str_replace("%DB_PASSWORD%",$request->get('password'),$new);
            $new  = str_replace("%IS_VERIFIED%",'true',$new);

            // Write the contents back to the file
            if(file_put_contents(base_path().'/.env', $new)){
                //Execute the database migrations using artisan
                ini_set('max_execution_time', 480);
                Artisan::call('migrate', array('--force' => true));
                Artisan::call('db:seed', array('--force' => true));
            }
            //Redirect to the next step
            return redirect('install/user');
        }
        catch (\Exception $e){
           \Flash::error('An installation error occured <br/><b> Reason:</b> '.$e->getMessage());
            return view('install.database');
        }
	}
    /**
     * Display the specified resource.
     */
    public function getUser()
	{
		return view('install.user');
	}
    /**
     * Show the form for editing the specified resource.
     *
     */
    public function postUser(InstallUserRequest $request)
	{
        $data = array(
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        );
        $role = $this->role->where('name', 'admin')->first();
        $data['role_id'] = $role->uuid;
        if($this->user->create($data)){
            //Create a install config file
            $config = "<?php 
                            return array('install' => true,
                                          'version' => 2,
                                          'install date' => '".date('Y-m-d H:i:s')."'
                                        );
                       ?>";
            \File::put(base_path().'/config/invoicer.php',$config);
            return redirect('login');
        }
        return view('install.user');
	}
    /*
     * Verify the purchase
     */
    public function postVerify(Request $request){
        (function_exists('curl_init')) ? '' : die('cURL Must be installed for geturl function to work. Ask your host to enable it or uncomment extension=php_curl.dll in php.ini');
        $data_string = array(
            'envato_username' => trim($request->envato_username),
            'purchase_code' =>  trim($request->purchase_code),
            'ip' => $_SERVER['REMOTE_ADDR'],
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.elantsys.com/license/index.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
        curl_setopt($ch, CURLOPT_MAXREDIRS, 15);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        $html = curl_exec($ch);
        if(curl_exec($ch) === false){
            return Response::json(array('success' => false, 'error' => 'Curl error: ' . curl_error($ch)), 422);
        }else {
            $json = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $html), true );
            if($json['success']){
                Config::write('services.license', [
                    'is_verified'=>true,
                    'purchase_code'=>trim($request->purchase_code),
                ]);
                if($this->setting->count() > 0) {
                    $setting = $this->setting->first();
                    $this->setting->updateById($setting->uuid, array('purchase_code'=>trim($request->purchase_code)));
                }
                else {
                    $this->setting->create(array('purchase_code'=>trim($request->purchase_code)));
                }
                Flash::success('Purchase code has been verified successfully!!!');
                return Response::json(array('success' => true, 'error' => ''), 200);
            }else{
                return Response::json(array('success' => false, 'error' => $json['error_msg']), 422);
            }
        }
        curl_close($ch);
    }
}
