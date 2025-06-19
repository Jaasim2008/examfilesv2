<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ExamFiles</title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script>
        (function () {
            const savedTheme = localStorage.getItem("theme");
            const defaultTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? "dark" : "light";
            const theme = savedTheme ? savedTheme : defaultTheme;
            document.documentElement.setAttribute("data-theme", theme);
        })();
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }
        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme');
            setTheme(current === 'light' ? 'dark' : 'light');
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text)
        }
        :root[data-theme="light"] {
            --text: #0f0d21;
            --background: #f2f0f9;
            --primary: #2b245b;
            --secondary: #ce83b7;
            --accent: #b6496d;
        }
        :root[data-theme="dark"] {
            --text: #e1dff2;
            --background: #06050d;
            --primary: #a9a3da;
            --secondary: #7d3266;
            --accent: #b7496e;
        }
        .text-base { color: var(--text); }
        .text-primary { color: var(--primary); }
        .text-secondary { color: var(--secondary); }
        .text-accent { color: var(--accent); }
        .bg-base { background-color: var(--background); }
        .bg-primary { background-color: var(--primary); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-accent { background-color: var(--accent); }

        #whatsappicon:hover {
            filter: invert(68%) sepia(88%) saturate(445%) hue-rotate(81deg) brightness(88%) contrast(87%);
        }
        #facebookicon:hover {
            filter: invert(30%) sepia(99%) saturate(2021%) hue-rotate(203deg) brightness(99%) contrast(91%);
        }
        #copylinkicon:hover {
            filter: invert(14%) sepia(29%) saturate(2645%) hue-rotate(222deg) brightness(96%) contrast(97%);
        }
    </style>
</head>
<body class="bg-base flex flex-col min-h-screen">
<section class="hidden md:inline fixed grid grid-rows-3 right-0 mr-6 bg-secondary gap-1 border border-t-0 divide-y divide-primary rounded-b-md" style="border-color: var(--primary);">
    <button class="p-1 flex gap-1 items-center" onclick="toggleTheme()"><img class="w-[28px] invert" src="{{ asset('assets/icons/moon.svg') }}"> Light/Dark Mode</button>
    <a href="/aboutme" class="p-1 flex gap-1 items-center"><img class="w-[28px] invert" src="{{ asset('assets/icons/person.svg') }}"> About Me</a>
    <a href="https://buymeacoffee.com/jaazim" target="_blank" class="p-1 flex gap-1 items-center"><img class="w-[28px] invert" src=" {{asset('assets/icons/heart.svg')}}"> Support Me</a>
    <button class="p-1 flex gap-1 items-center w-full" onclick="document.location.href = '/frosty'"><img class="w-[28px] invert" src="{{asset('assets/icons/theme.svg')}}"> Switch Theme</button>
</section>
<main class="p-10 flex-grow">
    <h1 class="text-4xl font-extrabold text-center mb-2">CBSE Previous Year Papers</h1>
    <p class="text-accent italic text-center mb-10">No Sign Up | No OTP | No Ads | Solved | One-Click Download</p>

    <div class="max-w-3xl mx-auto">
        <form method="GET" class="flex flex-wrap items-center gap-4 mb-10 pl-2">
            <label class="text-lg">Filter:</label>
            <select name="year" class="bg-secondary text-white px-2 py-1 rounded">
                <option value="">All Years</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" @if ($year == $selectedYear) selected @endif>{{ $year }}</option>
                @endforeach
            </select>

            <select name="sub" class="bg-secondary text-white px-2 py-1 rounded">
                <option value="">All Subjects</option>
                @foreach ($subjects as $sub)
                    <option value="{{ $sub }}" @if ($sub == $selectedSub) selected @endif>{{ $sub }}</option>
                @endforeach
            </select>

            <input type="text" name="qp" placeholder="Search QP filename..." value="{{ request('qp') }}" class="text-white placeholder-slate-100 px-2 py-1 rounded border bg-secondary" style="border-color: var(--primary);" />
            <button type="submit" class="bg-primary text-white px-4 py-1 rounded hover:bg-secondary transition">Apply</button>
            <a href="?" class="text-sm text-primary hover:text-secondary underline">Clear</a>
        </form>

        <div class="overflow-y-auto max-h-[calc(100vh-200px)] md:overflow-visible">
            <table class="min-w-full table-auto border-collapse border border-gray-700">
                <thead>
                <tr class="bg-secondary text-white">
                    <th class="border border-gray-700 px-4 py-2 text-left">Year</th>
                    <th class="border border-gray-700 px-4 py-2 text-left">Class/Subject</th>
                    <th class="border border-gray-700 px-4 py-2 text-left">QP</th>
                    <th class="border border-gray-700 px-4 py-2 text-left">MS</th>
                </tr>
                </thead>
                <tbody>
                @if (count($filteredData) > 0)
                    @foreach ($filteredData as $row)
                        <tr class="border-b border-gray-700">
                            <td class="border border-gray-700 px-4 py-2">{{ $row['Year'] }}</td>
                            <td class="border border-gray-700 px-4 py-2">{{ $row['Class/Subject'] }}</td>
                            <td class="border border-gray-700 px-4 py-2 truncate max-w-xs">
                                <a target="_blank" class="text-primary underline hover:text-accent" href="{{ $row['QP'] }}">
                                    {{ basename(parse_url($row['QP'], PHP_URL_PATH)) }}
                                </a>
                            </td>
                            <td class="border border-gray-700 px-4 py-2 truncate max-w-xs">
                                <a target="_blank" class="text-primary underline hover:text-accent" href="{{ $row['MS'] }}">
                                    {{ basename(parse_url($row['MS'], PHP_URL_PATH)) }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="4" class="text-center py-4 text-gray-400">No matching papers found.</td></tr>
                @endif
                </tbody>
            </table>
            <a>Download Subject (zip)</a>
        </div>
    </div>
</main>
{{-- Socials CTA --}}
<section class="z-20 fixed right-0 top-[50%] hidden md:grid grid-cols-2 bg-secondary gap-1 border border-r-0 rounded-s-lg" dir="ltr" style="border-color: var(--primary);">
    <div class="p-1 grid grid-rows-3 gap-2">
        <a href="#"><img id="whatsappicon" class="w-[28px] invert" src="{{asset('assets/icons/whatsapp.svg')}}"></a>
        <a href="#"><img id="facebookicon" class="w-[28px] invert" src="{{asset('assets/icons/facebook.svg')}}"></a>
        <a href="#"><img id="copylinkicon" class="w-[28px] invert" src="{{asset('assets/icons/copylink.svg')}}"></a>
    </div>
    <div class="p-1 border-l border-white flex items-center"><p class="[writing-mode:vertical-lr]">Share Me!</p></div>
</section>
{{-- Mobile Socials CTA --}}
{{-- TODO: Link up the Links in Index --}}
<section class="grid grid-cols-4 justify-items-center md:hidden text-sm border-t bg-secondary rounded-md rounded-b-none p-2" style="border-color: var(--primary);">
    <img class="w-[20px]" src="{{ asset('assets/frostyicons/share.svg') }}" alt="Share:">
    <a href="#"><img id="whatsappicon" class="w-[20px]  invert" src="{{ asset('assets/icons/whatsapp.svg') }}" alt="Whatsapp"></a>
    <a href="#"><img id="facebookicon" class="w-[20px]  invert" src="{{ asset('assets/icons/facebook.svg') }}" alt="Facebook"></a>
    <a href="#"><img id="copylinkicon" class="w-[20px]  invert" src="{{ asset('assets/icons/copylink.svg') }}" alt="Copy link"></a>
</section>
<footer class="grid grid-cols-2 grid-rows-2 grid-flow-col pb-1 md:hidden flex justify-center items-center bg-secondary gap-1 text-sm border-t" style="border-color: var(--primary);">
    <button class="p-1 hover:text-secondary flex gap-1 items-center justify-center" onclick="toggleTheme()"><img class="w-[20px] invert" src="{{ asset('assets/icons/moon.svg') }}" alt=""> Light/Dark Mode</button>
    <button class="p-1 flex gap-1 items-center justify-center" onclick="document.location.href = '/frosty'"><img class="w-[20px] invert" src="{{ asset('assets/icons/theme.svg') }}"> Switch Theme</button>
    <a href="/aboutme" class="p-1 hover:text-secondary flex gap-1 items-center justify-center"><img class="w-[20px] invert" src="{{ asset('assets/icons/person.svg') }}" alt=""> About Me</a>
    <a href="https://buymeacoffee.com/jaazim" target="_blank" class="p-1 hover:text-secondary flex gap-1 items-center justify-center"><img class="w-[20px] invert" src="{{ asset('assets/icons/heart.svg') }}" alt=""> Support Me</a>
</footer>
</body>
</html>
