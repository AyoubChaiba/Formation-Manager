@extends('admin.layout.app')

@section('title' , "إضافة برنامج")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'تكوين برنامج'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="program" name="program">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_Data">التاريخ</label>
                                    <select name="date_id" id="date" class="form-control">
                                        <option value="" >اختر تاريخًا</option>
                                        @foreach (getDates() as $date)
                                            <option {{ $program->date_id == $date->id ? "selected" : "" }} value="{{ $date->id }}">{{ $date->year }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">المجال</label>
                                    <input type="text" name="domaine" id="domaine" class="form-control" placeholder="المجال"  value="{{ $program->domaine }}" >
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">تحديث</button>
                    <a href="{{ route('program.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $("#program").submit(function(e){
            e.preventDefault();
            const program = $(this);
            $('#btn-submit').text('جاري التحميل ...');
            $.ajax({
                url: "{{ route('program.update',$program->id) }}",
                method: "PUT",
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
                        $('#date_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
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
                    $('#btn-submit').text('تحديث');
                }
            })
        })
    </script>
@endsection
