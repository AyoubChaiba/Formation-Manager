@extends('admin.layout.app')

@section('title' , "List Contact beneficiaries")

@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contact beneficiaries</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary">back</a>
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
                                    <th>PPR</th>
                                    <th>Full name</th>
                                    <th>Workplace</th>
                                    <th>Gender</th>
                                    <th>Phone number</th>
                                    <th>Email</th>
                                    <th>URl</th>
                                    <th>Answered</th>
                                    {{-- <th>date send</th>
                                    <th>Time send</th> --}}
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $item)
                                    <tr>
                                        <td>{{ $item->GetBeneficiarie->ppr }}</td>
                                        <td>{{ $item->GetBeneficiarie->first_name. " ". $item->GetBeneficiarie->last_name }}</td>
                                        <td>{{ $item->GetBeneficiarie->workplace  }}</td>
                                        <td>{{ $item->GetBeneficiarie->gender }}</td>
                                        <td>{{ $item->GetBeneficiarie->phone_number }}</td>
                                        <td>{{ $item->GetBeneficiarie->email }}</td>
                                        <td><a href="{{ $item->url }}" >link</a></td>
                                        <td>
                                            @if ($item->status == 1)
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-warning-500 h-6 w-6 text-warning" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                            @endif
                                        </td>
                                        {{-- <td>{{ $item->GetBeneficiarie->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $item->GetBeneficiarie->created_at->format('H:i') }}</td> --}}
                                        <td>
                                            <a href="{{ route('msg.index',$item->GetBeneficiarie->id) }}">
                                                <svg class="w-[32px] h-[32px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M3 5.983C3 4.888 3.895 4 5 4h14c1.105 0 2 .888 2 1.983v8.923a1.992 1.992 0 0 1-2 1.983h-6.6l-2.867 2.7c-.955.899-2.533.228-2.533-1.08v-1.62H5c-1.105 0-2-.888-2-1.983V5.983Zm5.706 3.809a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Zm2.585.002a1 1 0 1 1 .003 1.414 1 1 0 0 1-.003-1.414Zm5.415-.002a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($contacts->isEmpty())
                            <div class="text-center my-4">not found eny dates</div>
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


