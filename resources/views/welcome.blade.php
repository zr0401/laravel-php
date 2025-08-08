@extends('layout')
@section('title', 'Welcome Page')
@section('content')

<style>
    h1, p { 
        text-align: center;
        margin-top: 10px;
    }

</style>

<div class="container">
    <div class="text">
        <h1>Welcome to the Application</h1>
        <p>This is a simple Laravel application.</p>
</div>
</div>

@endsection