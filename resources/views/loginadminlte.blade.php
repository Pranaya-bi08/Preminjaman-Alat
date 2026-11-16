<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AdminLTE 3 | Log in (v2)</title>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min') }}.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min') }}.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min') }}.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<!-- /.login-logo -->
<div class="card card-outline card-primary">
<div class="card-header text-center">
<a href="#" class="h1"><b>Admin</b>LTE</a>
</div>
<div class="card-body">
<p class="login-box-msg">Sign in to start your session</p>
<form action="{{ route('actionLogin') }}" method="post">
@csrf
<div class="input-group mb-3">
<input type="email" class="form-control" name="email" placeholder="Email">
<div class="input-group-append">
<div class="input-group-text">
    <span class="fas fa-envelope"></span>
</div>
</div>
</div>
<div class="input-group mb-3">
<input type="password" class="form-control" name="password" placeholder="Password">
<div class="input-group-append">
<div class="input-group-text">
<span class="fas fa-lock"></span>
</div>
</div>
</div>
<div class="row">
<!-- /.col -->
<div class="col-4">
<button type="submit" class="btn btn-primary btn-block">Sign In</button>
</div>
<!-- /.col -->
</div>
</form>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- Sweet Alert 2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if (session('success'))
Swal.fire({
icon: "success",
title: "Berhasil",
text: "{{ session('success') }}",
showConfirmButton: true
});
@elseif (session('error'))
Swal.fire({
icon: "error",
title: "Gagal !",
text: "{{ session('error') }}",
showConfirmButton: true
});
@endif
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Pesan dari server (flash message)
    @if (session('success'))
        Swal.fire({ toast: true, position: 'top-end', icon: 'success',
                    title: @json(session('success')), showConfirmButton: false, timer: 2500 });
    @endif
    @if (session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')) });
    @endif

    // Konfirmasi otomatis untuk form apa pun yang punya atribut data-confirm
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!form.dataset.confirm) return;
        e.preventDefault();
        Swal.fire({
            title: 'Yakin?',
            text: form.dataset.confirm,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal',
        }).then(function (r) { if (r.isConfirmed) form.submit(); });
    });
</script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
</body>
</html>