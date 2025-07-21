@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Category List</h1>
    </div>

    {{-- List --}}
    <div class="">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('#create') }}" method="POST" class="p-3 rounded">
                            @csrf
                            <input type="text" name="categoryName" value="{{ old('categoryName') }}" id="" class="form-control" placeholder="Category Name">
                            @error('categoryName')
                                <small class="text-danger">{{ $message }}</small><br>
                            @enderror
                            <input type="submit" value="Submit" class="btn btn-outline-primary p-2 mt-2">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col offset-1">

                <table class="table table-hover">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Created Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $c)
                        <tr>
                        <th>{{ $c->id }}</th>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->created_at->format('j-F-Y') }}</td>
                        <td>
                            <a href="{{ route('update#Page',$c->id) }}" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="{{ route('#delete',$c->id) }}" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                <span class="d-flex justify-content-center">{{ $category -> links() }}</span>
            </div>

        </div>
    </div>
</div>
{{-- @if(session('alert'))
        <script>

            alert("{{ session('alert') }}");
        </script>
 @endif --}}
@endsection
