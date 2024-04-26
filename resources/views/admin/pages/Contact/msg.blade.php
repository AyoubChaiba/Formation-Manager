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
                                    <th>Course</th>
                                    <th>Start date</th>
                                    <th>Start Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->getCourse->name }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->time }}</td>
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


