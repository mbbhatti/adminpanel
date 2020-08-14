@extends('Layout.layout')

@section('title', 'Dashboard')

@section('css')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div class="container-fluid animated fadeIn" style="margin-top: 30px;">
        <?php
        $users = getTotalUsers();
        $posts = getTotalPost();
        $categories = getTotalCategories();
        $products = getTotalProducts();
        ?>
        {{-- Display cards --}}
        @include('Admin.Dashboard.card', compact('users', 'posts', 'categories', 'products'))

        {{-- Display latest posts --}}
        @include('Admin.Dashboard.post')

        <div class="row">
            {{-- Display chart --}}
            @include('Admin.Dashboard.chart')

            {{-- Latest users --}}
            @include('Admin.Dashboard.user')
        </div>

        {{-- Visitor report map --}}
        @include('Admin.Dashboard.map')
    </div>
@stop
