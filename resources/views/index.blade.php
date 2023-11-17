<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CRUD Data Table In Laravel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('crud/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>s
    <script src="{{ url('crud/main.js') }}"></script>
</head>

<body>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Laravel <b>Crud System</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#Studentmodel" class="btn btn-success ADD" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i> <span>Add New </span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                        <label for="checkbox1"></label>
                                    </span>
                                </td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->address }}</td>
                                <td>
                                    <a href="#Studentmodel" class="edit EDIT" data-toggle="modal"
                                        data-id="{{ $student->id }}" data-name="{{ $student->name }}"
                                        data-email="{{ $student->email }}" data-phone="{{ $student->phone }}"
                                        data-address="{{ $student->address }}"><i class="material-icons"
                                            data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                    <a href="#deleteStudent" class="delete DELETE" data-toggle="modal"
                                        data-id="{{ $student->id }}"><i class="material-icons" data-toggle="tooltip"
                                            title="Delete">&#xE872;</i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Custom Pagination Links -->
                <div class="clearfix">
                    <div class="hint-text">
                        Showing <b>{{ $students->firstItem() }}</b> to <b>{{ $students->lastItem() }}</b> of <b>{{ $students->total() }}</b> entries
                    </div>

                    <ul class="pagination">
                        @if ($students->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                        @else
                            <li class="page-item"><a href="{{ $students->previousPageUrl() }}" class="page-link">Previous</a></li>
                        @endif

                        @php
                            $startPage = max($students->currentPage() - 1, 1);
                            $endPage = min($students->lastPage(), $startPage + 2);
                        @endphp

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ ($i == $students->currentPage()) ? 'active' : '' }}">
                                <a href="{{ $students->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($students->hasMorePages())
                            <li class="page-item"><a href="{{ $students->nextPageUrl() }}" class="page-link">Next</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal  -->
    <div id="Studentmodel" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('student.add') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-titles">Add Student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="nname" class="form-control" required>
                        </div>
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="nemail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" name="phone" id="nphone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" id="naddress" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal  -->
    <div id="deleteStudent" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('student.delete') }}" method="post">
                    @csrf
                    <input type="hidden" id="did" name="id">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Employee</h4>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(".ADD").on("click", function() {
            $('#modal-titles').text('Add Student')
            $('#id').val('')
            $('#nname').val('')
            $('#nemail').val('')
            $('#nphone').val('')
            $('#naddress').val('')

            $("#Studentmodel").modal("show")
        })

        $(".EDIT").on("click", function() {
            $('#modal-titles').text('Edit Student')
            $('#id').val($(this).data('id'))
            $('#nname').val($(this).data('name'))
            $('#nemail').val($(this).data('email'))
            $('#nphone').val($(this).data('phone'))
            $('#naddress').val($(this).data('address'))

            $("#Studentmodel").modal("show")
        })
            $(".DELETE").on("click", function() {
                $('#did').val($(this).data('id'))
                $("#deleteStudent").modal("show")
            })
        </script>
    </body>
    </html>
