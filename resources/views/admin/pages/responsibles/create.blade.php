@extends('admin.layout.app')

@section('title' , "Add responsible")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Create responsible'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="responsible" name="responsible">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">First name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Last name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Phone number</label>
                                    <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Phone number">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Create</button>
                    <a href="{{ route('responsible.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $("#responsible").submit(function(e){
            e.preventDefault();
            const project = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('responsible.store') }}",
                method: "POST",
                data: project.serializeArray(),
                dataType: "json",
                success: function(data){
                    if (!data['status']) {
                        const { email , first_name, last_name, phone_number }  = data['errors'];
                        email ? $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(email)
                        : $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        first_name ? $('#first_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(first_name)
                        : $('#first_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        last_name ? $('#last_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(last_name)
                        : $('#last_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        phone_number ? $('#phone_number').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(phone_number)
                        : $('#phone_number').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    } else {
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#first_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#last_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#phone_number').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        Swal.fire({
                            icon:'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('responsible.index') }}";
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

