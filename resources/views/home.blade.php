@extends('layouts.app')

@section('content')

<div class="container">
    {{Auth::user()->name}} Welcome!
</div>

@endsection
