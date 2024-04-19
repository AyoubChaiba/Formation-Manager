@extends('admin.layout.app')

@section('title' , "Add program")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Create program'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="program" name="program">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_Data">Date</label>
                                    <select name="date_id" id="date" class="form-control">
                                        <option value="" >selecte a date</option>
                                        @foreach (getDates() as $date)
                                            <option {{ tempData()->year == $date->year ? "selected" : "" }} value="{{ $date->id }}">{{ $date->year }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Name program</label>
                                    <input type="text" name="domaine" id="domaine" class="form-control" placeholder="Name program">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Create</button>
                    <a href="{{ route('program.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        // const dateId = $('#date_id').val();
        // $('#id_Data').val(dateId);
        $("#program").submit(function(e){
            e.preventDefault();
            const program = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('program.store') }}",
                method: "POST",
                data: program.serializeArray(),
                dataType: "json",
                success: function(data){
                    if (!data['status']) {
                        const { date_id , domaine }  = data['errors'];
                        date_id ? $('#date').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(date_id)
                        : $('#date').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        domaine ? $('#domaine').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(domaine)
                        : $('#domaine').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    } else {
                        $('#data_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#domaine').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        Swal.fire({
                            icon:'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('program.index') }}";
                            }
                        })
                    }
                },
                error: function(error){
                    console.log(error);
                },
                complete: function(){
                    $('#btn-submit').text('Create');
                }
            })
        })
    </script>
@endsection

