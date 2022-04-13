@extends('layouts.app')

@section('title')
Detail Story
@endsection

@section('breadcrumb')
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Story</li>
        <li class="breadcrumb-item active">Detail Story</li>
        <!-- Breadcrumb Menu-->
    </ol>
@endsection

@section('container')
  @foreach($storys as $story)
    <h3 class="text-center">{{ $story->title }}</h3><br>
    <img src="{{ 'storage/app/public/'. $story->image }}" class="rounded mx-auto d-block" style="width:600px; height:400px;"><br>
    <div class="container" style="width:800px; height:600px">
      <p class="text-center">{{ $story->content }}</p><br>
    </div>
  @endforeach
@endsection

@push('scripts')
@endpush