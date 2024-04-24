<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>اختيار الدورة</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    body {
        direction: rtl;
    }

</style>
<body>
<div class="container mt-5">

    <div class="jumbotron">
        <h1 class="display-4 text-right">مرحبا بك, {{ $beneficiarie->first_name. " ".$beneficiarie->last_name }}</h1>
        <p class="lead text-right">نحن سعداء بزيارتك ونود أن نقدم لك مجموعة من الدورات المتاحة لدينا.</p>
        <hr class="my-4">
        <p class="text-right">يرجى اختيار الدورة التي ترغب في حضورها وتحديد التاريخ والوقت المناسبين لك.</p>
    </div>
<form action="{{ route("wish.store") }}" method="POST">
    @csrf
    <input type="hidden" name="beneficiarie_id" value="{{ $beneficiarie->id }}">
    <div class="form-group">
        <div class="mb-3 text-right">
            <label for="course_id">اختر الدورة:</label>
            <select name="course_id" id="course_id" class="form-control">
                <option value="" >حدد دورة</option>
                @foreach ($courses as $course)
                    <option  value="{{ $course->GetCourses->id }}">{{ $course->GetCourses->name }}</option>
                @endforeach
            </select>
            @error('course_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="row text-right">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="dateSelection">تاريخ  بدء في الدورة :</label>
                <input type="date" class="form-control" id="date" name="date">
            </div>
            @error('date')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="timeSelection">وقت مناسب لحضور :</label>
                <input type="time" class="form-control" id="time" name="time">
            </div>
            @error('time')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">إرسال</button>
</form>
</div>

<!-- إضافة رابط Bootstrap JS و Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
