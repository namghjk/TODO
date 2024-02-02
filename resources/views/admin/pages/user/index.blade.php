@extends('partials.main')
@section('content')
    <!-- Delete All Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" action="{{ route('manage-user.destroy', ['manage_user' => ':user_id']) }}"
                    method="POST">
                    @method('DELETE')
                    @csrf
                    <!-- Modal -->

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_delete_id" id="user_id">
                        <h5>Are you sure you want to delete this user</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete user</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-auto row justify-content-between">

                            <div class="col-sm-8 col-md-2">
                                <form method="GET" action="{{ route('search_user') }}">
                                    <div class="input-group rounded">

                                        <input type="search" class="form-control rounded w-75" placeholder="Search"
                                            aria-label="Search" aria-describedby="search-addon" name ="search"
                                            value="{{ isset($search) ? $search : '' }} " />
                                        <button type="submit" class="input-group-text border-0" id="search-addon">
                                            <i class="fas fa-search"></i>
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table id="example1" class="table table-bordered table-striped mt-2 ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manage_users as $manage_user)
                                <tr>
                                    <td>{{ $manage_user->id }}</td>
                                    <td>{{ $manage_user->name }}</td>
                                    <td>{{ $manage_user->email }}</td>
                                    <td>{{ $manage_user->addresss }}</td>
                                    <td>{{ $manage_user->status }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-danger mr-1 deleteUserBtn" style="border-radius: 4px"
                                                data-post-id="{{ $manage_user }}"><i class="fa fa-trash"></i></a>

                                            <a href="{{ route('manage-user.edit', ['manage_user' => $manage_user]) }}"
                                                class="btn btn-primary mr-1" style="border-radius: 4px"><i
                                                    class="fa fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Add more rows for additional data -->
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $manage_users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.deleteUserBtn').click(function(e) {
                e.preventDefault();

                var user_id = $(this).data('user-id');
                $('#user_id').val(user_id);

                var form = $('#deleteForm');
                var action = form.attr('action');
                action = action.replace(':user_id', user_id);
                form.attr('action', action);


                $('#deleteModal').modal('show');
            })
        })
    </script>
@endsection
