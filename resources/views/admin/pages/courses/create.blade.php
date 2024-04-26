@extends('admin.layout.app')

@section('title' , "Add course")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Create course'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="course" name="course">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_id">Programs</label>
                                    <select name="program_id" id="program_id" class="form-control">
                                        <option value="" >selecte a programs</option>
                                        @foreach ($programs as $program)
                                            <option  value="{{ $program->id }}">{{ $program->domaine }} - عدد فئات مستهدفة ({{ $program->get_targetgroups_count }}) </option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 d-flex flex-column">
                                    <label for="target_group_id">Target groups</label>
                                    <select name="target_group_id[]" id="target_group_id" multiple>
                                    </select>
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Course name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Course name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="course_type">Type formation</label>
                                    <select name="course_type" id="course_type" class="form-control">
                                        <option value="" >selecte a projects</option>
                                        <option value="presence">Presence</option>
                                        <option value="remote">Remote</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date">Date start</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date">Date end</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
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
                    <a href="{{ route('course.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $(document).ready(function() {
            $('#target_group_id').multiselect({
                includeSelectAllOption: true,
                buttonWidth: '100%',
            });
        });
        $("#course").submit(function(e){
            e.preventDefault();
            const course = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('course.store') }}",
                method: "POST",
                data: course.serializeArray(),
                dataType: "json",
                success: function(data){
                    if (!data['status']) {
                        if (data.errors['target_group_id']) {
                            $('.multiselect').addClass('is-invalid');
                            $('#error').addClass('invalid-feedback d-block').html(data.errors['target_group_id']);
                        } else {
                            $('.multiselect').removeClass('is-invalid');
                            $('#error').removeClass('invalid-feedback').html('');
                        }
                        ['program_id', 'name', 'course_type', 'start_date', 'end_date'].forEach(element => {
                            const error = data.errors[element];
                            if (error) {
                                $(`#${element}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error);
                            } else {
                                $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            }
                        });
                    } else {
                        ['program_id', 'name', 'course_type', 'start_date', 'end_date'].forEach(element => {
                            $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        });
                        Swal.fire({
                            icon:'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('course.index') }}";
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
                    // $("#example-select").append('<option value="">Select a target group</option>');
                    data.forEach(element => {
                        $("#target_group_id").append(`<option value="${element.id}">${element.name} - course (${element.get_courses_count})</option>`);
                    });
                    $('#target_group_id').multiselect('rebuild');
                },
                error: function(error){
                    console.log(error);
                }
            })
        })
    </script>
@endsection

