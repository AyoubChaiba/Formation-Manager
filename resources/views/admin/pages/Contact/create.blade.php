@extends('admin.layout.app')

@section('title' , "Add contact")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Create contact'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="contact" name="contact">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_id">Programs</label>
                                    <select name="program_id" id="program_id" class="form-control">
                                        <option value="" >selecte a programs</option>
                                        @foreach ($programs as $program)
                                            <option  value="{{ $program->id }}">{{ $program->domaine }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="target_group_id">Target groups</label>
                                    <select name="target_group_id" id="target_group_id" class="form-control">
                                        <option value="" >selecte a target groups</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="code">Message</label>
                                    <textarea name="message" id="message" class="form-control" placeholder="Message"></textarea>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 d-flex flex-column">
                                    <label for="provider">Provider</label>
                                    <select name="provider[]" id="provider" multiple>
                                        <option value="sms">SMS</option>
                                        <option value="whatsapp">Whatsapp</option>
                                        <option value="email">Email</option>
                                    </select>
                                    <p id="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Send message</button>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
                        title: 'Please wait...',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                success: function(data){
                    $('#btn-submit').text('Send message');
                    if (!data.error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
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
                    $('#btn-submit').text('Send message');
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
                    $("#target_group_id").append('<option value="">Select a target group</option>');
                    data.forEach(element => {
                        $("#target_group_id").append(`<option value="${element.id}">${element.name}</option>`);
                    });
                },
                error: function(error){
                    console.log(error);
                }
            })
        })
    </script>
@endsection

