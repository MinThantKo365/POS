@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
        </div>

        {{-- List --}}
        <div class="">
            <div class="row">
                <div class="col-5 offset-2">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('change#pwd#update') }}" method="POST" class="p-3 rounded">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Old Password</label>
                                    <input type="password" class="form-control  @error('oldPassword') is-inpasswordvalid @enderror" name="oldPassword"
                                        placeholder="enter old password">
                                        @error('oldPassword')
                                            <small class="text-danger">{{ $message }}</small><br>
                                        @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword"
                                        placeholder="enter new password">
                                        @error('newPassword')
                                            <small class="text-danger">{{ $message }}</small><br>
                                        @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control @error('confirmPassword') is-invalid @enderror" name="confirmPassword"
                                        placeholder="enter confirm password">
                                        @error('confirmPassword')
                                            <small class="text-danger">{{ $message }}</small><br>
                                        @enderror
                                </div>
                                <div class="">
                                    <input type="submit" value="Change Password" class="btn btn-outline-primary p-2 mt-2">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- @if (session('alert'))
        <script>
            alert("{{ session('alert') }}");
        </script>
    @endif --}}
@endsection
