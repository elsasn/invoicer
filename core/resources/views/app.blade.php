<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{get_company_name()}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href='http://fonts.googleapis.com/css?family=Ruda&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins-->
    <link href="{{ asset('assets/css/theme-skin.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pace.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/pikaday/pikaday.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/animsition/css/animsition.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/amaranjs//css/amaran.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper animsition">
<header class="main-header">
    <a href="{{url('/')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>C</b>I 2</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{ asset('assets/img/logo.png') }}" alt="logo"/></span>
    </a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-fixed-top navbar-default" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
<ul class="nav navbar-nav">
    <li class="dropdown">
        <?php
            if(Session::has('applocale')){
                $current_lang = get_current_language(Session::get('applocale'));
                if(!$current_lang){
                    $current_lang = get_default_language();
                    if(!$current_lang){
                        $current_lang = get_current_language(App::getLocale());
                    }
                }
            }
            else{
                $current_lang = get_default_language();
                if(!$current_lang){
                    $current_lang = get_current_language(App::getLocale());
                }
            }
            $current_flag = $current_lang->flag != '' ? $current_lang->flag : 'placeholder_Flag.jpg';
        ?>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('assets/img/flags/'.$current_flag) }}" class="language-img">{{ $current_lang->locale_name }} <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <?php $languages = get_languages(); ?>
            @foreach($languages as $language)
                @if ($language->short_name != $current_lang->short_name)
                    <?php $flag = $language->flag != '' ? $language->flag : 'placeholder_Flag.jpg'; ?>
                <li>
                    <a rel="alternate" href="{{ route('admin_lang_switch', $language->short_name) }}">
                        <img src="{{ asset('assets/img/flags/'.$flag) }}" class="language-img">{{ $language->locale_name }}
                    </a>
                </li>
                    <li class="divider"></li>
                @endif
            @endforeach
        </ul>
    </li>
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        @if(auth()->guard('admin')->check())
        <img src="{{ asset( auth()->guard('admin')->user()->photo != '' ? 'assets/img/uploads/'.auth()->guard('admin')->user()->photo : 'assets/img/uploads/defaultavatar.png') }}" class="user-image" alt="User Image"/>
        <span class="hidden-xs"> {{  auth()->guard('admin')->user()->name }} </span>
        @endif
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            @if(auth()->guard('admin')->check())
            <img src="{{ asset( auth()->guard('admin')->user()->photo != '' ? 'assets/img/uploads/'.auth()->guard('admin')->user()->photo : 'assets/img/uploads/defaultavatar.png') }}" class="img-circle" alt="User Image" />
            <p>{{  auth()->guard('admin')->user()->name }} </p>
            @endif
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ url('profile') }}" class="btn btn-primary btn-sm btn-flat">{{trans('application.edit_profile')}}</a>
            </div>
            <div class="pull-right">
                <a href="{{ route('admin_logout') }}" class="btn btn-danger btn-sm btn-flat">{{trans('application.logout')}}</a>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
@include('nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@yield('content')
</div><!-- /.content-wrapper -->
    <div id="ajax-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"></div>
    @if(!is_verified())
    <div id="activation-modal" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Verification of the license</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'/settings/verify','id'=>'verify_form']) !!}
                    <div class=" col-xs-3 col-sm-3">
                        <img src="{{asset('assets/img/lock.png')}}" width="100%">
                    </div>
                    <div class="col-xs-9 col-sm-9 ">
                        <div class="form-group">
                            <label for="envato_username">Envato Username</label>
                            <input type="text" class="form-control input-sm" required name="envato_username" id="envato_username" placeholder="Enter your envato username here"/>
                        </div>
                        <div class="form-group">
                            <label for="envato_username">Purchase Code</label>
                            <input type="text" class="form-control input-sm" name="purchase_code" id="purchase_code" placeholder="Enter your purchase code here"/>
                            <span style="font-size:12px;"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Where can I find my purchase code ?</a></span>
                        </div>
                        <div class="form-group">
                            <a href="javascript:" onclick="checkLicense()" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-check"></span>Verify</a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="alert alert-info" style="font-size:12px;  margin-bottom: 0px;" >
                            <span class="glyphicon glyphicon-warning-sign" style="margin-right: 12px;float: left;font-size: 22px;margin-top: 10px;margin-bottom: 10px;"></span>
                            Each website using this plugin needs a legal license (1 license = 1 website).<br/>
                            To read find more information on envato licenses,
                            <a href="https://codecanyon.net/licenses/standard" target="_blank">click here</a>.<br/>
                            If you need to buy a new license of this plugin, <a href="https://codecanyon.net/item/classic-invoicer/6193251?ref=elantsys" target="_blank">click here</a>.
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    {!! Form::close() !!}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    @endif
</div><!-- ./wrapper -->
<!-- jQuery 2.1.3 -->
<script src="{{ asset('assets/js/jquery-2.1.3.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap Dialog -->
<script src="{{ asset('assets/js/bootstrap-dialog.js') }}"></script>
<!-- Jquery Datatables -->
<script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('assets/js/datatables.js') }}"></script>
<!-- Pace.js -->
<script src="{{ asset('assets/js/pace.min.js') }}"></script>
<!-- summernote.js javascript -->
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- datepicker.js javascript-->
<script src="{{ asset('assets/plugins/pikaday/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/pikaday/pikaday.js') }}"></script>
<script src="{{ asset('assets/plugins/pikaday/pikaday.jquery.js') }}"></script>
<!-- chosen.js javascript-->
<script src="{{ asset('assets/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('assets/plugins/animsition/js/jquery.animsition.min.js') }}" type="text/javascript"></script>
<!-- validator.js javascript-->
<script src="{{ asset('assets/js/validator.min.js') }}"></script>
<!-- toastr.js javascript-->
<script src="{{ asset('assets/plugins/amaranjs/js/jquery.amaran.min.js') }}"></script>
<!-- custom.js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
@yield('scripts')
@include('common.common_js')
@if (Session::has('flash_notification.level'))
    <?php $message_type = Session::get('flash_notification.level'); ?>
    @if($message_type == 'success')
        <script>
            $.amaran({
                'theme'     :'awesome ok',
                'content'   :{
                    title:'Success !',
                    message:'{{ Session::get('flash_notification.message') }}!',
                    info:'',
                    icon:'fa fa-check-square-o'
                },
                'position'  :'bottom right',
                'outEffect' :'slideBottom'
            });
        </script>
    @elseif($message_type == 'danger')
        <script>
            $.amaran({
                'theme'     :'awesome error',
                'content'   :{
                    title:'Error !',
                    message:'{{ Session::get('flash_notification.message') }}!',
                    info:'',
                    icon:'fa fa-times-circle-o'
                },
                'position'  :'bottom right',
                'outEffect' :'slideBottom'
            });
        </script>
    @endif
@endif
</body>
</html>