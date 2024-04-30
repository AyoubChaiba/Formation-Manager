@extends('admin.layout.app')

@section('title' , "إضافة جهة اتصال")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'إنشاء جهة اتصال'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="contact" name="contact">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_id">البرامج</label>
                                    <select name="program_id" id="program_id" class="form-control">
                                        <option value="" >اختر برنامجًا</option>
                                        @foreach ($programs as $program)
                                            <option  value="{{ $program->id }}">{{ $program->domaine }} - عدد فئات مستهدفة ({{ $program->get_targetgroups_count }}) </option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="target_group_id">الفئات المستهدفة</label>
                                    <select name="target_group_id" id="target_group_id" class="form-control">
                                        <option value="" >اختر مجموعة مستهدفة</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6" dir="rtl">
                                <div class="mb-3">
                                    <label for="code">الرسالة</label>
                                    <textarea name="message" id="message" class="form-control" placeholder="الرسالة" style="height: 180px">نود أن نقدم لك مجموعة من الدورات المتاحة لدينا.</textarea>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3" dir="rtl">
                                    <label for="code">عرض الرسالة</label>
                                    <div class="card card-body">
                                        <h4 class="text-right">مرحبًا، <span class="text-primary">اسم المستفيد</span> </h4>
                                        <p class="text-right" id="show_message">نود أن نقدم لك مجموعة من الدورات المتاحة لدينا.</p>
                                        <p class="text-right" >رابط اختيار الدورة التي ترغب في حضورها وتحديد التاريخ والوقت المناسبين لك.</p>
                                        <a  class="text-right text-success" href="#">هنا</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 d-flex flex-column">
                                    <label for="provider">مزود الخدمة</label>
                                    <select name="provider[]" id="provider" multiple>
                                        <option value="sms">رسالة نصية</option>
                                        <option value="whatsapp">واتساب</option>
                                        <option value="email">البريد الإلكتروني</option>
                                    </select>
                                    <p id="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">إرسال الرسالة</button>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $(document).ready(function() {
            $('#provider').multiselect({
                includeSelectAllOption: true,
                buttonWidth: '100%',
            });
        });
        $("#contact").submit(function(e){
            e.preventDefault();
            const contact = $(this);
            // $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('contact.store') }}",
                method: "POST",
                data: contact.serializeArray(),
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: 'يرجى الانتظار...',
                        allowEscapeKey: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                success: function(data){
                    $('#btn-submit').text('إرسال الرسالة');
                    if (!data.error) {
                        Swal.fire({
                            icon: "error",
                            title: "عذرًا...",
                            text: data.error_message,
                        });
                    }
                    if (!data['status']) {
                        ['program_id', 'target_group_id', 'message', 'provider'].forEach(element => {
                            const error = data.errors[element];
                            if (error) {
                                $(`#${element}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error);
                            } else {
                                $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            }
                        });
                    } else {
                        ['program_id', 'target_group_id', 'message', 'provider'].forEach(element => {
                            $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        });
                        Swal.fire({
                            icon:'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('contact.index') }}";
                            }
                        })
                    }
                },
                error: function(error){
                    console.log(error);
                },
                complete: function(){
                    $('#btn-submit').text('إرسال الرسالة');
                }
            })
        })
        $("#program_id").change(function(e){
            $.ajax({
                url: "{{ route('program-target.get') }}",
                method: "GET",
                data: {
                    id: $(this).val()
                },
                dataType: "json",
                success: function(data){
                    $("#target_group_id").empty();
                    $("#target_group_id").append('<option value="">اختر مجموعة مستهدفة</option>');
                    data.forEach(element => {
                        $("#target_group_id").append(`<option value="${element.id}">${element.name} - الدورة (${element.get_courses_count})</option>`);
                    });
                },
                error: function(error){
                    console.log(error);
                }
            })
        })
        $("#message").change(function(e) {
            const message = $(this).val();
            $("#show_message").html(`<p class="text-right">${message}</p>`);
        })
    </script>
@endsection
