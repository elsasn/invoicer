@extends('modal')
@section('content')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title">{{trans('application.pay_invoice')}}</h5>
            </div>
            @if($paypal_details['status'] || $stripe_details['status'])
                {!! Form::open(['route' => ['getCheckout']]) !!}
                <div class="modal-body" style="padding-bottom: 0">
                    <input type="hidden" name="selected_method" id="selected_method"/>
                    <input type="hidden" name="invoice_id" value="{{$invoice_id}}"/>
                    <header class="header">
                        <div class="card-type">
                            @if($paypal_details['status'])
                                <a class="card" href="#" id="paypal" onclick="selected_method(this);">
                                    <img src="{{ asset('assets/img/paypal_logo.png') }}">
                                </a>
                            @endif
                             @if($stripe_details['status'])
                            <a class="card" href="#" id="stripe" onclick="selected_method(this);">
                                <img src="{{ asset('assets/img/stripe_logo.png') }}">
                            </a>
                            @endif
                        </div>
                    </header>
                </div>
                <div class="modal-footer">
                    <button class="btn button" disabled id="method_btn">{{trans('application.complete_payment')}}</button>
                </div>
                {!! Form::close() !!}
            @else
                <div class="modal-body" style="padding-bottom: 0">
                    <div class="alert alert-warning">{{trans('application.no_gateway_available')}}</div>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
    <style>
        .header {
            background: #00A6EA;
            padding: 15px;
            text-align: center;
        }
        .modal .header h1 {
            margin: 0 0 15px;
            color: #FFF;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .modal .header .card-type .card {
            position: relative;
            width: 50%;
            min-width: 54px;
            text-align: center;
            -webkit-transition: 0.3s ease;
            -moz-transition: 0.3s ease;
            -o-transition: 0.3s ease;
            transition: 0.3s ease;
            -webkit-filter: grayscale(100%);
            -moz-filter: grayscale(100%);
            filter: grayscale(100%);
        }
        .modal .header .card-type {
            display: -webkit-box;
            display: -moz-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-direction: normal;
            -moz-box-direction: normal;
            -webkit-box-orient: horizontal;
            -moz-box-orient: horizontal;
            -webkit-flex-direction: row;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }
        .modal .header .card-type .card.active {
            -webkit-filter: grayscale(0);
            -moz-filter: grayscale(0);
            filter: grayscale(0);
        }
        .modal .header .card-type .card.active:after {
            display: block;
            bottom: -15px;
        }
        .modal .header .card-type .card:after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 50%;
            margin: 0 0 0 -10px;
            border-right: 10px solid transparent;
            border-left: 10px solid transparent;
            border-bottom: 10px solid #FFF;
            -webkit-transition: 0.3s ease;
            -moz-transition: 0.3s ease;
            -o-transition: 0.3s ease;
            transition: 0.3s ease;
        }
        .modal .modal-footer .button {
            outline: none;
            display: block;
            background: #5cb85c;
            width: 100%;
            border: 0;
            padding: 20px 30px;
            color: #FFF;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
        }
    </style>
@endsection