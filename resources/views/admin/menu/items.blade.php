@extends('layouts.admin')
@section('content')

    <menu-component :menus="{{ $category->menus }}" :category="{{  $category  }}" ></menu-component>
@endsection
