@extends('app')
@section('content')
    <div class="col-md-12 content-header" >
        <h1><i class="fa fa-th-large"></i> {{trans('application.categories')}}</h1>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title pull-right">
                            <div class="box-tools">
                                <a href="{{ route('product_category.create') }}" class="btn btn-primary btn-xs pull-right" data-toggle="ajax-modal"> <i class="fa fa-plus"></i> {{trans('application.new_category')}}</a>
                            </div>
                        </h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{trans('application.name')}}</th>
                                <th>{{trans('application.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($categories->count() > 0)
                                @foreach($categories as $category)
                                    <tr>
                                        <td></td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            {!! edit_btn('product_category.edit', $category->uuid) !!}
                                            {!! delete_btn('product_category.destroy', $category->uuid) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection