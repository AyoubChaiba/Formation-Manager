@extends('admin.layout.app')

@section('title', "إضافة تواريخ")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'إنشاء تاريخ'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="date" name="date">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name">السنة</label>
                                    <input type="number" name="year" id="year" class="form-control" placeholder="السنة">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date">تاريخ البدء</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date">تاريخ الانتهاء</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">إنشاء</button>
                    <a href="{{ route('date.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
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
        $('#btn-submit').text('جارٍ التحميل ...');
        $.ajax({
            url: "{{ route('date.store') }}",
            method: "POST",
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
                $('#btn-submit').text('إنشاء');
            }
        })
    })
</script>
@endsection
