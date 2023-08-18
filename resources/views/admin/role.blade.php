@extends('layout/secondLayout')

@section('title', 'Role')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12">
                    <h3 class="font-weight-bold">Role</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#roleModal">
                        Add Role
                    </button>
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Admin</td>
                                <td>
                                    <button class="btn btn-warning"><i class="mdi mdi-table-edit"></i> Edit</button>
                                    <button class="btn btn-danger"><i class="mdi mdi-delete"></i> Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Operator</td>
                                <td>
                                    <button class="btn btn-warning"><i class="mdi mdi-table-edit"></i> Edit</button>
                                    <button class="btn btn-danger"><i class="mdi mdi-delete"></i> Delete</button>
                                </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleModalLabel">Add Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="#!">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="text" class="form-control" id="role" placeholder="Enter role">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    

@endsection
