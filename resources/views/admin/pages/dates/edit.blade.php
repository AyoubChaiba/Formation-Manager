@extends('admin.layout.app')

@section('title' , "Edit Date")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Edit date'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="date" name="date">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Year</label>
                                    <input type="number" name="year" id="year" class="form-control" placeholder="Year" value="{{ $date->year }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date">Date start</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $date->start_date }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date">Date end</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $date->end_date }}">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Update</button>
                    <a href="{{ route('date.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $("#date").submit(function(e){
            e.preventDefault();
            const date = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('date.update' , $date->id) }}",
                method: "PUT",
                data: date.serializeArray(),
                dataType: "json",
                success: function(data){
                    if (!data['status']) {
                        const { year , start_date, end_date }  = data['errors'];
                        year ? $('#year').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(year)
                        : $('#year').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        start_date ? $('#start_date').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(start_date)
                        : $('#start_date').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        end_date ? $('#end_date').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(end_date)
                        : $('#end_date').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    } else {
                        $('#year').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#start_date').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#end_date').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        Swal.fire({
                            icon:'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('date.index') }}";
                            }
                        })
                    }
                },
                error: function(error){
                    console.log(error);
                },
                complete: function(){
                    $('#btn-submit').text('Update');
                }
            })
        })
    </script>
@endsection
