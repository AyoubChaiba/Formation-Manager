@extends('admin.layout.app')

@section('title' , "قائمة مستفيدي الاتصال")

@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>مستفيدي الاتصال</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('contact.create') }}" class="btn btn-primary">اتصال جديد</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <x-alert type="success" >{{ session('success') }}</x-alert>
                @endif
                @if (Session::has('error'))
                    <x-alert type="warning" >{{ session('error') }}</x-alert>
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
                                    <th>الرقم التعريفي</th>
                                    <th>البرامج</th>
                                    <th>الفئة المستهدفة</th>
                                    <th>مزود الخدمة</th>
                                    <th>عدد المستفيدين</th>
                                    <th>تاريخ الإرسال</th>
                                    <th>وقت الإرسال</th>
                                    <th width="100">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->Programs->domaine }}</td>
                                        <td>{{ $item->TargetGroups->name  }}</td>
                                        <td>{{ $item->provider }}</td>
                                        <td>المستفيدين ({{ count($item->GetBeneficiaries) }})</td>
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $item->created_at->format('H:i') }}</td>
                                        <td>
                                            <a href="{{ route('show.index',$item->id) }}">
                                                <button class="btn btn-link">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
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
                        @if($contacts->isEmpty())
                            <div class="text-center my-4">لم يتم العثور على أي بيانات</div>
                        @endif
                    </div>
                    <div class="card-footer clearfix">
                        {{ $contacts->links() }}
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
                text: "لن تتمكن من التراجع عن ذلك!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، احذفها!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('contact.delete', ':id') }}".replace(':id', id),
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
                                title: "فشل!",
                                text: "فشل في حذف الاتصال.",
                                icon: "error"
                            });
                        }
                    })
                }
            });
        })
    </script>
@endsection
