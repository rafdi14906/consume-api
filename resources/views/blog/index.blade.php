@extends('layouts.app')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">{{ $title }}</h1>
            <div class="btn-toolbar mb-2 mb-md-0">

            </div>
        </div>

        <button id="btnAdd" class="btn btn-sm btn-primary">Add</button>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogs as $blog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->content }}</td>
                            <td>
                                <button id="btnEdit" onclick="edit({{ $blog->id }}, '{{ $blog->title }}', '{{ $blog->content }}')" class="btn btn-sm btn-warning">Edit</button>
                                <button id="btnDelete" onclick="deleteData({{ $blog->id }})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <div class="modal fade" id="modalForm" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formBlog">
                        @csrf
                        <input type="hidden" name="_method" id="_method">
                        <input type="hidden" id="id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" name="content" id="content" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteData(id) {
            let c = confirm('Anda yakin hapus?');
            if (c) {
                let url = `{{ route('blog.delete', ':id') }}`;
                url = url.replace(':id', id);
                window.location.href = url;
            }
        }

        function edit(id, title, content) {
            $('#id').val(id);
            $('#title').val(title);
            $('#content').val(content);

            let url = `{{ route('blog.update', ':id') }}`;
            url = url.replace(':id', id);
            $('#formBlog').attr('action', url);
            $('#_method').val('PUT');

            $('.modal-title').text('Edit')
            $('#modalForm').modal('show');
        }

        $('#btnAdd').on('click', function() {
            $('#id').val('');
            $('#title').val('');
            $('#content').val('');

            $('#formBlog').attr('action', `{{ route('blog.store') }}`);
            $('#_method').val('POST');

            $('.modal-title').text('Add')
            $('#modalForm').modal('show');
        });

        $('#btnSubmit').on('click', function() {
            $('#formBlog').submit();
        });
    </script>
@endsection
