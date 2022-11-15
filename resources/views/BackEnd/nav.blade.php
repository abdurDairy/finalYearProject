@extends('BackEnd.blank')
@section('content')
    <div class="container">
        <div class="row">
            {{--*****TABLE FOR NAVIGATION DATA***** --}}
            <div class="col-lg-8">
                <table class="table table-responsive ">
                    <tr class="text-center">
                        <th>SN</th>
                        <th>Logo</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                        <th>Status</th>
                    </tr>

                    {{-- *****FETCH ALL DATA FROM DATABASE*** --}}
                    @foreach ($allInfoNav as $key => $nav)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>
                            <img src="{{ $nav->nav_image }}" style="width: 100px" alt="{{ $nav->nav_address }}">
                        </td>
                        <td>{{ $nav->nav_phone }}</td>
                        <td>{{ $nav->nav_address }}</td>
                        <td>
                           <div class="btn-group">
                            <a href="{{ route('nav.edit',$nav->nav_phone) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger deleteNavElement">Delete</a>
                            <form action="{{ route('nav.delete',$nav->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                           </div>
                        </td>
                        <td>
                            {{-- ****** STATUS CHECK BTN **** --}}
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="statusCheck" name="nav_status">
                              </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            {{-- ****FORM FOR NAVIGATION DATA***** --}}
            <div class="col-lg-4">
                @if (!isset($navEdit))
                <div class="card">
                    {{-- ***SUCCESS MESSAGE START*** --}}
                      @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                       @endif
                     {{-- ***SUCCESS MESSAGE END*** --}}
                    {{-- ***DELETE MESSAGE START*** --}}
                      @if(session()->has('delete'))
                        <div class="alert alert-danger">
                            {{ session()->get('delete') }}
                        </div>
                       @endif
                     {{-- ***DELETE MESSAGE END*** --}}

                    <div class="card-header bg-info py-3 text-light">
                        <h4>Add Navigation Info</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('nav.insert') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="form-control my-2" name="navLogoImage">
                                @error('navLogoImage')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            <input type="text" class="form-control my-2" placeholder="Add Phone Number" name="navPhoneNumber" value="{{ old('navPhoneNumber') }}">
                                @error('navPhoneNumber')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            <textarea name="navAddress" placeholder="Add Navigation Information..." class="form-control my-2"></textarea>
                                @error('navAddress')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            <button class="btn btn-primary w-100">submit</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="card">
                    {{-- ***SUCCESS MESSAGE START*** --}}
                      @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                       @endif
                     {{-- ***SUCCESS MESSAGE END*** --}}

                    <div class="card-header bg-info py-3 text-light">
                        <h4>Update Navigation Info</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('nav.update',$navEdit->nav_phone) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="file" class="form-control my-2" name="navLogoImage">
                                @error('navLogoImage')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            <input type="text" class="form-control my-2" placeholder="Add Phone Number" name="navPhoneNumber" value="{{ $navEdit->nav_phone }}">
                                @error('navPhoneNumber')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            <textarea name="navAddress" placeholder="Add Navigation Information..." class="form-control my-2">{{ $navEdit->nav_address}}</textarea>
                                @error('navAddress')
                                    <span class="text-danger"><strong>{{ $message }}</strong></span>
                                @enderror
                            <button class="btn btn-primary w-100">Update</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @endsection
    {{-- ************ SWEET ALERT ************ --}}

@section('navDeleteSweetAlert2')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <SCript>
        $('.deleteNavElement').on('click',function(){

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $(this).next('form').submit()
            }
        })
        })
    </SCript>
@endsection