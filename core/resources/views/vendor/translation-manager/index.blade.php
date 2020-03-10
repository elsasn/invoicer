@extends('app')
@section('content')
<div class="col-md-12 content-header" >
    <h1><i class="fa fa-globe"></i> Language Manager</h1>
</div>
<section class="content">
    <div class="row">
    <div class="col-md-3">
        @include('settings.partials._menu')
    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header">
                <a href="{{ route('translations.index') }}" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Back to Languages</a>
            </div>
            {!! Form::hidden('locale', $locale, ['id' => 'locale']) !!}
            <div class="box-body scrollable" style="max-height: 1000px">
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i>
                        Warning, translations are not visible until they are exported back to the app/lang file, using 'php artisan translation:export' command or publish button.
                    </div>
                <div class="alert alert-success success-find" style="display:none;">
                    <p>Done searching for translations, found <strong class="counter">N</strong> items!</p>
                </div>
                @if(Session::has('successPublish'))
                    <div class="alert alert-info">
                        {{ Session::get('successPublish') }}
                    </div>
                @endif
                {!! Form::open(['url'=>['translations/import'], 'data-remote'=>'true', 'class'=>'form-inline', 'role'=>'form']) !!}
                <div class="form-group">
                    {!! Form::select('replace', array('0'=>'Append new translations', '1'=>'Replace existing translations'), null, ['class'=>'form-control input-sm']) !!}
                    <button type="submit" class="btn btn-sm btn-success"  data-disable-with="Loading..">Import groups</button>
                </div>
                {!! Form::close() !!}
                <br/>
                {!! Form::open(['url'=>['translations/find'], 'data-remote'=>'true', 'role'=>'form', 'class' => 'form-find', 'data-confirm'=>'Are you sure you want to scan you app folder? All found translation keys will be added to the database.']) !!}
                <div class="form-group ">
                    <button type="submit" class="btn btn-sm btn-primary" data-disable-with="Searching.." >Find translations in files</button>
                </div>
                {!! Form::close() !!}
                {!! Form::open() !!}
                <?php echo $group; ?>
                    <div class="input-group col-md-4">
                        {!! Form::select('group',$groups,$group,['class'=>'form-control group-select input-sm'] ) !!}
                    </div>
                <br/>
                {!! Form::close() !!}
                @if($group)
                {!! Form::open(['url' => ['translations/add', $group]]) !!}
                <div class="form-group ">
                {!! Form::textarea('keys',null,['class'=>'form-control','placeholder'=>'Add 1 key per line, without the group prefix']) !!}
                    </div>
                    <input type="submit" value="Add keys" class="btn btn-sm btn-primary">
                {!! Form::close() !!}
                    <h4>Total: {{ $numTranslations }}, changed: {{ $numChanged }}</h4>
                    <div class="alert alert-success success-publish" style="display:none;">
                        <p>Done publishing the translations for group '{{ $group }}'!</p>
                    </div>
                    @if(isset($group))
                        {!! Form::open(['url'=>['translations/publish', $group], 'data-remote'=>'true', 'role'=>'form', 'class' => 'form-publish', 'data-confirm'=>'Are you sure you want to publish the translations group '. $group.'? This will overwrite existing language files.']) !!}
                        <div class="form-group ">
                            <button type="submit" class="btn btn-sm btn-success" data-disable-with="Publishing.." >Publish translations</button>
                        </div>
                        {!! Form::close() !!}
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="15%">Key</th>
                            <th>{{$locale}}</th>
                            @if($deleteEnabled)
                                <th>&nbsp;</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($translations as $key => $translation)
                            <tr id="{{ $key }}">
                                <td>{{ $key }}</td>

                                    <?php $t = isset($translation[$locale]) ? $translation[$locale] : null ?>
                                    <td>
                                        <a href="#edit" class="editable status-{{ $t ? $t->status : 0 }} locale-{{ $locale }}" data-locale="{{ $locale }}" data-name="{{ $locale . "|" . $key }}" id="username" data-type="textarea" data-pk="{{ $t ? $t->id : 0 }}" data-url="{{ $editUrl }}" data-title="Enter translation">{{ $t ? htmlentities($t->value, ENT_QUOTES, 'UTF-8', false) : '' }}</a>
                                    </td>
                                @if($deleteEnabled)
                                    <td>
                                        <a href="<?= action('\Barryvdh\TranslationManager\Controller@postDelete', [$group, $key]) ?>" class="delete-key" data-msg="Are you sure you want to delete the translations for '{{ $key }}'?"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                <div class="alert alert-success success-publish" style="display:none;">
                    <p>Done publishing the translations for group '{{ $group }}'!</p>
                </div>
                @if(isset($group))
                {!! Form::open(['url'=>['translations/publish', $group], 'data-remote'=>'true', 'role'=>'form', 'class' => 'form-publish', 'data-confirm'=>'Are you sure you want to publish the translations group '. $group.'? This will overwrite existing language files.']) !!}
                <div class="form-group ">
                    <button type="submit" class="btn btn-sm btn-success" data-disable-with="Publishing.." >Publish translations</button>
                </div>
                {!! Form::close() !!}
                @endif
                @else <br/>
                    <div class="alert alert-info">Choose a group to display the group translations. If no groups are visible, make sure you have run the migrations and imported the translations.</div>
                @endif
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('scripts')
@include('settings.partials.settings_js')
@endsection
