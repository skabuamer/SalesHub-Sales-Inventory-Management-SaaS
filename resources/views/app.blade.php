<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.9.0/fonts/remixicon.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet" />

    {{-- @vite('resources/js/app.js') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-inertia::head />
</head>

<body class="max-w-full bg-[#0e0e10] text-[#e8e3db] min-h-screen">
    <x-inertia::app />
</body>

</html>
