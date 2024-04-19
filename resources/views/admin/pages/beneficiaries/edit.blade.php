@extends('admin.layout.app')

@section('title' , "Edit beneficiarie")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Edit beneficiarie'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="beneficiarie" name="beneficiarie">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_id">Programs</label>
                                    <select name="program_id" id="program_id" class="form-control">
                                        <option value="" >selecte a programs</option>
                                        @foreach ($programs as $program)
                                            <option {{ $program->id == $beneficiarie->program_id ? "selected" : "" }} value="{{ $program->id }}">{{ $program->domaine }}</option>
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
                                        @foreach ($target_groups as $target_group)
                                            <option {{ $target_group->id == $beneficiarie->target_group_id ? "selected" : "" }} value="{{ $target_group->id }}">{{ $target_group->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name">First name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" value="{{ $beneficiarie->first_name }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name">Last name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" value="{{ $beneficiarie->last_name }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ppr">Numéro de location PPR</label>
                                    <input type="text" name="ppr" id="ppr" class="form-control" placeholder="Numéro de location PPR" value="{{ $beneficiarie->ppr }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="workplace">Workplace</label>
                                    <select name="workplace" id="workplace" class="form-control">
                                        <option value="" >selecte a workplace</option>
                                        <option {{ $beneficiarie->workplace == "ابتدائية" ? "selected" : "" }} value="ابتدائية" >ابتدائية</option>
                                        <option {{ $beneficiarie->workplace == "اعدادية"  ? "selected" : "" }} value="اعدادية" >اعدادية</option>
                                        <option {{ $beneficiarie->workplace == "تأهيلية"  ? "selected" : "" }} value="تأهيلية" >تأهيلية</option>
                                        <option {{ $beneficiarie->workplace == "المديرية" ? "selected" : "" }} value="المديرية">المديرية</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="" >selecte a gender</option>
                                        <option {{ $beneficiarie->gender == "male" ? "selected" : "" }} value="male">Male</option>
                                        <option {{ $beneficiarie->gender == "female" ? "selected" : "" }} value="female">Female</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone_number">Phone number</label>
                                    <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Phone number" value="{{ $beneficiarie->phone_number }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $beneficiarie->email }}">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Update</button>
                    <a href="{{ route('beneficiarie.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $("#beneficiarie").submit(function(e){
            e.preventDefault();
            const beneficiarie = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('beneficiarie.update',$beneficiarie->id) }}",
                method: "PUT",
                data: beneficiarie.serializeArray(),
                dataType: "json",
                success: function(data){
                    if (!data['status']) {
                        ['program_id', 'target_group_id', 'first_name', 'last_name', 'ppr', 'workplace', 'gender','phone_number','email'].forEach(element => {
                            const error = data.errors[element];
                            if (error) {
                                $(`#${element}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error);
                            } else {
                                $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            }
                        });
                    } else {
                        ['program_id','target_group_id', 'first_name', 'last_name', 'ppr', 'workplace', 'gender','phone_number','email'].forEach(element => {
                            $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        });
                        Swal.fire({
                            icon:'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('beneficiarie.index') }}";
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

