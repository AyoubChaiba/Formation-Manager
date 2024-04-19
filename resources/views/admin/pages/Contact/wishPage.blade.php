<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>مرحبا بك في دوراتنا</title>
<!-- إضافة رابط Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <!-- رسالة الترحيب -->
  <div class="jumbotron">
    <h1 class="display-4">مرحبا بك!</h1>
    <p class="lead">نحن سعداء بزيارتك ونود أن نقدم لك مجموعة من الدورات المتاحة لدينا.</p>
    <hr class="my-4">
    <p>يرجى اختيار الدورة التي ترغب في حضورها وتحديد التاريخ والوقت المناسبين لك.</p>
  </div>

  <!-- نموذج اختيار الدورة وتحديد التواريخ والأوقات -->
  <form>
    <div class="form-group">
      <label for="courseSelection">اختر دورة:</label>
      <select class="form-control" id="courseSelection">
        <option>دورة تطوير الويب</option>
        <option>دورة تصميم الجرافيك</option>
        <option>دورة البرمجة بلغة جافا</option>
        <!-- يمكنك إضافة المزيد من الدورات هنا -->
      </select>
    </div>
    <div class="form-group">
      <label for="dateSelection">تاريخ الدورة:</label>
      <input type="date" class="form-control" id="dateSelection">
    </div>
    <div class="form-group">
      <label for="timeSelection">وقت الدورة:</label>
      <input type="time" class="form-control" id="timeSelection">
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
