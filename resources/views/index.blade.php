@extends('layouts.core.backend')

@section('title', $plugin->title)

@section('page_header')

    <div class="page-title">				
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li><a href="{{ action("Admin\HomeController@index") }}">{{ trans('messages.home') }}</a></li> / 
            <li><a href="{{ action("Admin\PluginController@index") }}">{{ trans('messages.plugins') }}</a></li>
        </ul>
        <div class="d-flex align-items-center">
            <div class="mr-4">
                <img width="80px" height="80px" src="{{ $plugin->getIconUrl() ? $plugin->getIconUrl() : url('/images/plugin.svg') }}" />
            </div>
            <div>
                <h1 class="mt-0 mb-2">
                    {{ $plugin->title }}
                </h1>
                <p class="mb-1">
                    {{ $plugin->description }}
                </p>
                <div class="text-muted">
                    <span>Version {{ $plugin->version }}</span>
                </div>
            </div>		
        </div>		
    </div>

@endsection

@section('content')

    <style type="text/css">
        article h2 {
            margin-top: 30px;
            margin-bottom: 16px;
        }

        li {
            font-size: 15px;
        }

        .from-group.col-md-6 {
            float: left;
            margin: 0 0 14px 0;
            padding: 0 15px 0 0;
        }

    </style>
    
    <div class="row">
        <div class="col-md-8">
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (\Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

            <article>
                <h2>Setting</h2>
                <p>This is very simple plugin allowing you to hook into Acelle NEW-CUSTOMER event and add the newly registered user to doox crm. Enter crm api details here...</p>
            </article>

            <div class="col-md-12">

                <form method="POST" action="{{ $saveListUrl }}">
                    @csrf
                    
                        <div class="from-group col-md-6">
                            <input type="text" name="apiurl" value="<?php if(!empty($apiurl)) { echo $apiurl; } ?>" class="form-control" placeholder="API URL" required>    
                        </div>

                        <div class="from-group col-md-6">
                            <input type="text" name="apitoken" value="<?php if(!empty($apitoken)) { echo $apitoken; } ?>"  class="form-control" placeholder="API Token" required>   
                        </div>

                        <div class="from-group col-md-6">
                            <input type="text" name="apistatus" value="<?php if(!empty($apistatus)) { echo $apistatus; } ?>"  class="form-control" placeholder="API Status" required>    
                        </div>

                        <div class="from-group col-md-6">
                            <input type="text" name="apisource" value="<?php if(!empty($apisource)) { echo $apisource; } ?>"  class="form-control" placeholder="API Source" required>    
                        </div>

                        <input type="submit" value="Save" class="btn btn-primary">

                </form>

            </div>
        </div>
    </div>
@endsection
