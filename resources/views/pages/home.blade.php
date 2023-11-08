@extends('layouts.app')

@section('content')
   <x-sidebar></x-sidebar>
   
   <div class="headers">
      <button class="open-sidebar">
            <ion-icon name="menu"></ion-icon>
      </button>

      <ul class="breadcrumb">
            <li> <a href="home.html">Home</a></li>      
      </ul>
   </div>
@endsection