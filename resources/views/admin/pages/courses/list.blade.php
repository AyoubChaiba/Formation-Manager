@extends('admin.layout.app')

@section('title' , "List course")

@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Courses</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('course.create') }}" class="btn btn-primary">New course</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <x-alert type="success" >{{ session('success') }}</x-alrt>
                @endif
                @if (Session::has('error'))
                    <x-alert type="warning" >{{ session('error') }}</x-alrt>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Domaine</th>
                                    <th>Name course</th>
                                    <th>Course type</th>
                                    <th>Duration</th>
                                    <th>Target group</th>
                                    <th>status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $item)
                                @php
                                    $firstDate = new DateTime($item->start_date);
                                    $lastDate = new DateTime($item->end_date);
                                    $interval = $firstDate->diff($lastDate)->format('%R%a days');
                                @endphp
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->Programs->domaine }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->course_type }}</td>
                                        <td>{{ $interval }}</td>
                                        <td>{{ count($item->TargetGroups) > 2 ? "Target group count ( " . count($item->TargetGroups) ." )" : $item->TargetGroups()->with('getGroup')->first()->getGroup->name }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('course.edit', $item->id) }}">
                                                <button class="btn btn-link">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </button>
                                            </a>
                                            <button class="btn btn-link" id="delete" data-id="{{ $item->id }}" >
                                                <svg class="filament-link-icon w-4 h-4 mr-1 text-danger" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($courses->isEmpty())
                            <div class="text-center my-4">not found eny courses</div>
                        @endif
                    </div>
                    <div class="card-footer clearfix">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('customJS')
    <script>
        $('.table').on('click', '#delete', function () {
            const id = $(this).data('id');
            const obj = $(this).parent().parent();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('course.delete', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire({
                                title: "Deleted!",
                                text: data['message'],
                                icon: "success"
                            });
                            obj.remove();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: "Failed!",
                                text: "Failed to delete course.",
                                icon: "error"
                            });
                        }
                    })
                }
            });
        })
    </script>
@endsection
