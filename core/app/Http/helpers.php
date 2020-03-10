<?php
function message(){
    $msghtml = '<div class="alert alert-'. Session::get('flash_notification.level') .'">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Message: </strong>'.Session::get('flash_notification.message').'</div>';
    return $msghtml;
}
function form_errors($errors){
    $error_list = '';
    foreach($errors->all() as $error){
        $error_list .= '- '.$error.'<br/>';
    }
    $errorsHtml = '<div class="alert alert-danger">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   '.$error_list.'</div>';
    return $errorsHtml;
}
function show_btn($route, $id){
    $btn = '<a class="btn btn-info btn-xs" href="'.route($route, $id).'" data-rel="tooltip" data-placement="top" title="'.trans("application.view").'"><i class="fa fa-eye"></i></a>';
    return $btn;
}
function edit_btn($route, $id){
    $btn = '<a class="btn btn-success btn-xs" data-toggle="ajax-modal" data-rel="tooltip" data-placement="top" href="'.route($route, $id).'" title="'.trans("application.edit").'"><i class="fa fa-pencil"></i></a>';
    return $btn;
}
function delete_btn($route, $id){
    $btn = Form::open(array("method"=>"DELETE", "route" => array($route, $id), 'class' => 'form-inline', 'style'=>'display:inline')).'
           <a class="btn btn-danger btn-xs btn-delete" data-rel="tooltip" data-placement="top" title="'.trans('application.delete').'"><i class="fa fa-trash"></i></a>'.Form::close();
    return $btn;
}
function format_amount($amount){
    $settings = App\Models\Setting::first();
    $thousand_separator = $settings && $settings->thousand_separator != '' ? $settings->thousand_separator : ',' ;
    $decimal_point = $settings && $settings->decimal_separator != '' ? $settings->decimal_separator : '.' ;
    $decimals = $settings && $settings->decimals != '' ? $settings->decimals : 2;
    return number_format(round($amount,$decimals),$decimals,$decimal_point,$thousand_separator);
}
function format_date($date){
    $settings = App\Models\Setting::first();
    $date_format = $settings && $settings->date_format != '' ? $settings->date_format : 'd-m-Y';
    return date($date_format, strtotime($date));
}
function get_company_name(){
    $settings = App\Models\Setting::first();
    $company_name = $settings && $settings->name != '' ? str_limit($settings->name, 20, '')  : 'Classic Invoicer';
    return $company_name;
}
function get_languages(){
    $languages = \DB::table('locales')->where('status', 1)->get();
    return $languages;
}
function get_current_language($lang){
    $language = \DB::table('locales')->where('short_name', $lang)->first();
    return $language;
}
function get_default_language(){
    $language = \DB::table('locales')->where('default', 1)->where('status', 1)->first();
    return $language;
}
function is_verified(){
    $settings = App\Models\Setting::first();
    $purchase_code = $settings ? $settings->purchase_code : '';
    if($purchase_code != '' && config('services.license.is_verified')){
        return true;
    }
    return false;
}
function form_buttons(){
    $buttons = '<button type="submit" data-rel="tooltip" data-placement="top" title="'.trans('application.save').'" class="btn btn-xs btn-success"><i class="fa fa-save"></i> '.trans("application.save").'</button>
                <button type="button" data-rel="tooltip" data-placement="top" title="'.trans('application.close').'" data-dismiss="modal" class="btn btn-xs btn-danger"> <i class="fa fa-times"></i> '.trans("application.close").'</button>';
    return $buttons;
}
function statuses(){
    return array(
        '0' => array(
            'status' => 'unpaid',
            'label' => trans('application.unpaid'),
            'class' => 'label-warning'
        ),
        '1' => array(
            'status' => 'partially_paid',
            'label' => trans('application.partially_paid'),
            'class' => 'label-primary'
        ),
        '2' => array(
            'status' => 'paid',
            'label' => trans('application.paid'),
            'class' => 'label-success'
        ),
        '3' => array(
            'status' => 'overdue',
            'label' => trans('application.overdue'),
            'class' => 'label-danger'
        )
    );
}
function getStatus($field, $value){
    $statuses = statuses();
   foreach($statuses as $key => $status){
       if ( $status[$field] === $value )
           return $key;
   }
   return false;
}
function hasPermission($permission, $show_msg = false){
    if(auth()->guard('admin')->user()->hasPermission($permission) || auth()->guard('admin')->user()->HasRole('admin')){
        return true;
    }else{
        if($show_msg)\Flash::error(trans('application.dont_have_permission'));
        return false;
    }
}
function parse_template($object, $body){
    if (preg_match_all('/\{(.*?)\}/', $body, $template_vars)){
        $replace ='';
        foreach ($template_vars[1] as $var){
            switch (trim($var)){
                case 'invoice_number':
                    if(isset($object->invoice->number)){
                        $replace = $object->invoice->number;
                    }
                    break;
                case 'invoice_amount':

                    if(isset($object->invoice->totals['grandTotal'])){
                        $replace = $object->invoice->currency.$object->invoice->totals['grandTotal'];
                    }
                    break;
                case 'client_name':
                    if(isset($object->client->name)){
                        $replace = $object->client->name;
                    }
                    break;
                case 'client_email':
                    if(isset($object->client->email)){
                        $replace = $object->client->email;
                    }
                    break;
                case 'client_number':
                    if(isset($object->client->lient_no)){
                        $replace = $object->client->lient_no;
                    }
                    break;
                case 'company_name':
                    if(isset($object->settings->name)){
                        $replace = $object->settings->name;
                    }
                    break;
                case 'company_email':
                    if(isset($object->settings->email)){
                        $replace = $object->settings->email;
                    }
                    break;
                case 'company_website':
                    if(isset($object->settings->website)){
                        $replace = $object->settings->website;
                    }
                    break;
                case 'contact_person':
                    if(isset($object->settings->contact)){
                        $replace = $object->settings->contact;
                    }
                    break;
                case 'username':
                    if(isset($object->user->username)){
                        $replace = $object->user->username;
                    }
                    break;
                case 'password':
                    if(isset($object->user->password)){
                        $replace = $object->user->password;
                    }
                    break;
                case 'login_link':
                    if(isset($object->user->login_link)){
                        $replace = $object->user->login_link;
                    }
                    break;
                default:
                    $replace = '';
            }
            $body = str_replace('{' . $var . '}', $replace, $body);
        }
    }
    return $body;
}
function array_multi_subsort($array, $subkey){
    $b = array(); $c = array();
    foreach ($array as $k => $v) {
        $b[$k] = strtolower($v[$subkey]);
    }
    asort($b);
    foreach ($b as $key => $val) {
        $c[] = $array[$key];
    }
    return $c;
}
function currency_convert($from_id,$amount){
    $default_currency = App\Models\Currency::where('default_currency',1)->first();
    $from_currency = App\Models\Currency::find($from_id);
    if($default_currency){
        $default_currency_value = $amount / $from_currency->exchange_rate * $default_currency->exchange_rate;
        return $default_currency_value;
    }else{
        return $amount;
    }
}
function defaultCurrency($symbol = false){
    $currency = App\Models\Currency::where('default_currency',1)->first();
    if($symbol){
        return $currency ? $currency->symbol : '$';
    }
    return $currency ? $currency->code.'('.$currency->symbol.')' : 'USD($)';
}
function defaultCurrencyCode(){
    $currency = App\Models\Currency::where('default_currency',1)->first();
    return $currency ? $currency->code : 'USD';
}
function getCurrencyId($symbol){
    $currency_code = explode("(", $symbol, 2)[0];
    $currency = App\Models\Currency::where('code',$currency_code)->first();
    return $currency->uuid;
}