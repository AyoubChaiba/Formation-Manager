@extends('admin.layout.app')

@section('title' , "Edit target group")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Edit target group'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="target_group" name="target_group">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="responsible_id">Responsibles</label>
                                    <select name="responsible_id" id="responsible_id" class="form-control">
                                        <option value="" >selecte a responsibles</option>
                                        @foreach ($responsibles as $responsible)
                                            <option  {{ $targetGroup->responsible_id == $responsible->id ? "selected" : "" }} value="{{ $responsible->id }}">{{ $responsible->first_name . " " . $responsible->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="program_id">Projects</label>
                                    <select name="program_id" id="program_id" class="form-control">
                                        <option value="" >selecte a programs</option>
                                        @foreach ($programs as $program)
                                            <option {{ $targetGroup->program_id == $program->id ? "selected" : "" }} value="{{ $program->id }}">{{ $program->domaine }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Target group</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Target group" value="{{ $targetGroup->name }}">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Update</button>
                    <a href="{{ route('targetGroup.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $("#target_group").submit(function(e){
            e.preventDefault();
            const program = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('targetGroup.update', $targetGroup->id) }}",
                method: "PUT",
                data: program.serializeArray(),
                dataType: "json",
                success: function(data){
                    if (!data['status']) {
                        const { responsible_id, program_id, name }  = data['errors'];
                        responsible_id ? $('#responsible_id').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(responsible_id)
                        : $('#responsible_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        program_id ? $('#program_id').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(program_id)
                        : $('#program_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        name ? $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(name)
                        : $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    } else {
                        $('#responsible_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#program_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        Swal.fire({
                            icon:'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('targetGroup.index') }}";
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

