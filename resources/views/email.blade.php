<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>مرحبا بك في دوراتنا</title>
</head>
<body>
<div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">مرحبا بك!</h1>
        <p class="lead">نحن سعداء بزيارتك ونود أن نقدم لك مجموعة من الدورات المتاحة لدينا.</p>
        <hr class="my-4">
        <p>يرجى اختيار الدورة التي ترغب في حضورها وتحديد التاريخ والوقت المناسبين لك.</p>
    </div>
    <div>
        {{ $subject }}
        {{ $emailMessage }}
    </div>
</div>
</body>
</html>
