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
            <div class="col-4 offset-1">

                <a href="{{ route('category#List') }}" class="btn btn-secondary text-light mb-2">Back</a>
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('#create') }}" method="POST" class="p-3 rounded">
                            @csrf
                            <input type="text" name="categoryName" id="categoryName" value="{{ old('categoryName', $category->name) }}" class="form-control" placeholder="Category Name">
                            @error('categoryName')
                                <small class="text-danger">{{ $message }}</small><br>
                            @enderror
                            <input type="submit" value="Submit" class="btn btn-outline-primary p-2 mt-2">
                        </form>
                    </div>
                </div>
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
