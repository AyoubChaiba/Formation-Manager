@extends('admin.layout.app')

@section('title' , "قائمة البرامج")

@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>البرامج</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('program.create') }}" class="btn btn-primary">برنامج جديد</a>
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
                                <input type="text" name="table_search" class="form-control float-right" placeholder="البحث">
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
                                    <th width="200">رقم البرنامج</th>
                                    <th>اسم البرنامج</th>
                                    <th>التاريخ</th>
                                    <th>عدد الدورات</th>
                                    <th width="100">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->domaine }}</td>
                                        <td>{{ $item->date->year }}</td>
                                        <td>{{ count($item->GetCourses) > 0 ? count($item->GetCourses) : "لم يتم العثور على دورات" }}</td>
                                        <td>
                                            <a href="{{ route('program.edit', $item->id) }}">
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
                        @if($programs->isEmpty())
                            <div class="text-center my-4">لم يتم العثور على أي برامج</div>
                        @endif
                    </div>
                    <div class="card-footer clearfix">
                        {{ $programs->links() }}
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
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع عن هذا!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، احذفها!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('program.delete', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire({
                                title: "تم الحذف!",
                                text: data['message'],
                                icon: "success"
                            });
                            obj.remove();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: "فشلت العملية!",
                                text: "فشلت عملية حذف البرنامج.",
                                icon: "error"
                            });
                        }
                    })
                }
            });
        })
    </script>
@endsection
