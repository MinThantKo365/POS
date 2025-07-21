@extends('admin.layouts.master')
@section('content')

<div class="container">
                <div class="jumbotron">
                  <div class="row">
                      <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                          <img src="{{asset(Auth::user()->profile == null ? 'admin/img/undraw_profile.svg' : 'profile/'.Auth::user()->profile)   }}" alt="stack photo" class="img">
                      </div>
                      <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                          <div class="container" style="border-bottom:1px solid black">
                            <h2>{{ Auth::user()->name == null ? Auth::user()->nickname : Auth::user()->name}}</h2>
                          </div>
                            <hr>
                          <ul class="container details" style="list-style-type: none;">
                            <li><p> <strong>Email: </strong><span class="glyphicon glyphicon-earphone one" style="width:50px;"></span>{{ Auth::user()->email }}</p></li>
                            <li><p> <strong>Phone: </strong><span class="glyphicon glyphicon-envelope one" style="width:50px;"></span>{{ Auth::user()->phone == null ? 'Null' : Auth::user()->phone }}</p></li>
                            <li><p> <strong>Address: </strong><span class="glyphicon glyphicon-map-marker one" style="width:50px;"></span>{{ Auth::user()->address == null ? 'Null' : Auth::user()->address}}</p></li>
                            <li><p> <strong>Role: </strong><span class="glyphicon glyphicon-map-marker one " style="width:50px;"></span>{{ Auth::user()->role }}</p></li>
                            <li><p><span class="" style="width:50px;"></span><a href="{{ route('change#pwd') }}" class="btn btn-primary">Change password</a> <a href="{{ route('change#pwd') }}" class="btn btn-secondary">Edit Profile</a> </p> </li>
                          </ul>
                      </div>
                  </div>
                </div>
@endsection
