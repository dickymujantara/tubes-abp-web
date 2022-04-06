@extends('layouts.app')

@section('title')
Story
@endsection

@section('breadcrumb')
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Story</li>
        <!-- Breadcrumb Menu-->
    </ol>
@endsection

@section('container')
<table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">TITLE</th>
        <th scope="col">CONTENT</th>
        <th scope="col">IMAGE</th>
        <th scope="col">LIKE COUNT</th>
        <th scope="col">ACTION</th>
      </tr>
    </thead>
    <tbody>
      @foreach($storys as $story)
        <tr>
            <th scope="row">{{ $story->id }}</th>
            <td>{{ $story->title }}</td>
            <td>{{ $story->content }}</td>
            <td><img src="{{ 'public/story/'. $story->image }}" style="width:300px; height:100px"></td>
            <td>{{ $story->like_count }}</td>
            <td>
                <form action="{{route('detailstory')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{ $story->id }}">
                  <button class="btn btn-primary" style="width:100px; color: white;"> <i class="fa fa-eye"></i> Detail</button>
                </form>
                <br>
                <form action="{{route('delete')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{ $story->id }}">
                  <button class="btn btn-danger" style="width:100px; color: white;"> <i class="fa fa-trash"></i> Delete</button>
                </form>
            </td>
        </tr>
      @endforeach
    </tbody>
</table>
@endsection

@push('scripts')
@endpush