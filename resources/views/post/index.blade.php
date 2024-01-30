@extends('partials.main')
@section('content')
    <!-- Delete All Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" action="{{ route('posts.destroy', ['post' => ':post_id']) }}" method="POST">
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
                        <input type="hidden" name="post_delete_id" id="post_id">
                        <h5>Are you sure you want to delete this post</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete post</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" action="{{ route('delete_all_posts') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <!-- Delete All Post Modal -->

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="post_delete_id" id="post_id">
                        <h5>Are you sure you want to delete all posts</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete all posts</button>
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
                        <div class=" mb-auto ">
                            <button id="deleteAllButton" class="btn btn-danger deleteAllPostBtn">Xoá tất cả</button>
                        </div>
                        <table id="example1" class="table table-bordered table-striped mt-2 ">
                            <thead>
                                <tr>
                                    <th>Thumbnail</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Published Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset($post->thumbnail) }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->description }}</td>
                                        <td>{{ $post->publish_date }}</td>
                                        <td>{{ $post->status }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a class="btn btn-danger mr-1 deletePostBtn" style="border-radius: 4px"
                                                    data-post-id="{{ $post->id }}"><i class="fa fa-trash"></i></a>

                                                <a href="{{ route('posts.edit', ['post' => $post->id]) }}"
                                                    class="btn btn-primary mr-1" style="border-radius: 4px"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-success mr-1"
                                                    style="border-radius: 4px"><i class="fa fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Add more rows for additional data -->
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{ $posts->links('pagination::bootstrap-4') }}
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
            $('.deletePostBtn').click(function(e) {
                e.preventDefault();

                var post_id = $(this).data('post-id');
                $('#post_id').val(post_id);

                var form = $('#deleteForm');
                var action = form.attr('action');
                action = action.replace(':post_id', post_id);
                form.attr('action', action);


                $('#deleteModal').modal('show');
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.deleteAllPostBtn').click(function(e) {
                e.preventDefault();
                $('#deleteAllModal').modal('show');
            })
        })
    </script>
@endsection
