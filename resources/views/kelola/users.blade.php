@extends('layout/secondLayout')

@section('title', 'Users')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12">
                    <h3 class="font-weight-bold">Users</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDataModal">
                        Add Data
                    </button>   
                    
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>                    
                    @endif

                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editDataModal{{$item->id}}"><i class="mdi mdi-table-edit"></i> 
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailDataModal{{$item->id}}"><i class="mdi mdi-information"></i> 
                                        Info
                                    </button>
                                    <form action="/users/{{$item->id}}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="mdi mdi-delete"></i> 
                                            Delete
                                        </button>
                                </td>



                                    {{-- Modal Info  --}}
        <div class="modal fade" id="detailDataModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    <form action="#!" method="POST">

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input name="name" type="text" readonly class="form-control" id="name" placeholder="Masukkan nama" value="{{old('name', $item->name)}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="email">Email</label>
                                <input name="email" readonly type="text" class="form-control" id="email" placeholder="Masukkan email" value="{{old('email', $item->email)}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editDataModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addDataModalLabel">Edit Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                    <form action="/users/{{$item->id}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="name">Nama</label>
                                                            <input name="name" required type="text" class="form-control" id="name" placeholder="Masukkan nama" value="{{old('name', $item->name)}}">
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="email">Email</label>
                                                                <input name="email" readonly required type="text" class="form-control" id="email" placeholder="Masukkan email" value="{{old('email', $item->email)}}">
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="password">Password</label>
                                                                <input name="password"  type="password" class="form-control" id="password" placeholder="Masukkan password" value="{{old('password')}}">
                                                                
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                          <button type="reset" class="btn btn-danger">Reset</button>
                                                        <button type="submit" class="btn btn-primary">save</button>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    <form action="/users/" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input name="name" type="text" class="form-control" id="nama" placeholder="Masukkan Nama" value="{{old('name')}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">email</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Masukkan email" value="{{old('email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">password</label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Masukkan password" value="{{old('password')}}">
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-primary">save</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
