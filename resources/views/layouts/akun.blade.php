<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.partials.kepala')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div id="scroll-progress"></div>
    <div class="min-h-screen">
        @include('layouts.navigasi')
        <main class="pt-[72px] lg:pt-[80px]">
            @yield('konten')
        </main>
        @include('layouts.footer')
    </div>
    @include('layouts.partials.kaki')
</body>
</html>
