<?php
$apiUrl = "https://oeoaaluonpvxpyuvzmnl.supabase.co/rest/v1/main";
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9lb2FhbHVvbnB2eHB5dXZ6bW5sIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTAwMTg5MDIsImV4cCI6MjA2NTU5NDkwMn0.ctACY-w4c4koCTcHN5nbMeNONBTncTMVSYUg-jyW-Xw";

$options = [
    "http" => [
        "method" => "GET",
        "header" => "apikey: $apiKey\r\n" .
                    "Authorization: Bearer $apiKey\r\n" .
                    "Accept: application/json\r\n"
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);
$data = json_decode($response, true);

// Get filters from URL
$selectedYear = $_GET['year'] ?? '';
$selectedSub  = $_GET['sub'] ?? '';
$searchQP     = strtolower($_GET['qp'] ?? '');

$filteredData = array_filter($data, function ($item) use ($selectedYear, $selectedSub, $searchQP) {
    $matchesYear = !$selectedYear || $item['Year'] == $selectedYear;
    $matchesSub = !$selectedSub || $item['Class/Subject'] == $selectedSub;
    $matchesQP = !$searchQP || strpos(strtolower(basename($item['QP'])), $searchQP) !== false;
    return $matchesYear && $matchesSub && $matchesQP;
});

// For dropdown population (unique values)
$years = array_unique(array_column($data, 'Year'));
sort($years);
$subjects = array_unique(array_column($data, 'Class/Subject'));
sort($subjects);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ExamFiles</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleTheme() {
        document.location.href = '/examfiles';
    }
  </script>


  <style>
    body {
      font-family: 'Inter', sans-serif;
      color: var(--text);
      background-color: lightblue;
    }
    :root {
        --comp: #A84958;
    }
    select, input, td > a {
        color: var(--comp) !important;
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
      /* Text Color Classes */
    .text-base {
        color: var(--text);
    }
    .text-primary {
        color: var(--primary);
    }
    .text-secondary {
        color: var(--secondary);
    }
    .text-accent {
        color: var(--accent);
    }
    /* Background Color Classes */
    .bg-base {
        background-color: var(--background);
    }
    .bg-primary {
        background-color: var(--primary);
    }
    .bg-secondary {
        background-color: var(--secondary);
    }
    .bg-accent {
        background-color: var(--accent);
    }

    @layer components {
        .aero {
            --hue: 245;
            --button-background: oklch(75% 0.1 var(--hue) / 0.8);
            --bg-dark: oklch(45% 0.1 var(--hue) / 0.75);
            --button-foreground: oklch(15% 0.05 var(--hue));
            background-color: var(--button-background);
            background:
                    linear-gradient(to bottom, rgba(255, 255, 255, 0.2), transparent) 0% 0%,
                    linear-gradient(to bottom, var(--bg-dark), var(--button-background));
            border: 1px solid var(--button-background);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);
            border-radius: 9999px;
            cursor: pointer;
            position: relative;
            color: var(--button-foreground);
            text-shadow: 0 2px 0.5em #0003;
            font-family: "Lucida Grande", "Lucida Sans Unicode", "Lunasima", sans-serif;
            transition: all 300ms ease;
        }

        .aero::after {
            content: "";
            position: absolute;
            top: 4%;
            left: 0.5em;
            width: calc(100% - 1em);
            height: 40%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.1));
            border-radius: 9999px;
            transition: background 400ms;
            pointer-events: none;
        }

        .aero:hover,
        .aero:focus {
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.4);
        }

        .aero:active {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }
    }

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
<body class="bg-cover bg-center bg-no-repeat bg-fixed flex flex-col min-h-screen">
<video autoplay  muted  loop  playsinline  class="fixed top-0 left-0 w-full h-full object-cover z-[-1]"><source src="https://oeoaaluonpvxpyuvzmnl.supabase.co/storage/v1/object/public/assets/bg.mp4" type="video/mp4"></video>
    <section class="hidden md:inline fixed grid grid-rows-3 right-0 mr-6 bg-secondary gap-1 border border-t-0 divide-y divide-primary rounded-b-md" style="border-color: #A84958;">
        <button class="p-1 hover:text-secondary flex gap-1 items-center" onclick="toggleTheme()"><img class="w-[28px]" src="theme.svg"> Switch Theme</button>
        <a href="/examfiles/aboutme.php" class="p-1 hover:text-secondary flex gap-1 items-center"><img class="w-[28px]" src="person.svg"> About Me</a>
        <a href="https://buymeacoffee.com/jaazim" target="_blank" class="p-1 hover:text-secondary flex gap-1 items-center"><img class="w-[28px]" src="heart.svg"> Support Me</a>
    </section>
    <!-- Main -->
    <main class="p-10 flex-grow">
    <h1 class="text-white text-4xl font-extrabold text-center mb-2" style="text-shadow: black 1px 0 6px;">CBSE Previous Year Papers</h1>
    <p class="italic text-center mb-10">No Sign Up | No OTP | No Ads | Solved | One-Click Download</p>

    <div class="max-w-3xl mx-auto">
        <form method="GET" class="flex flex-wrap items-center gap-4 mb-10 pl-2 h-full w-full bg-blue-900 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100 py-5">
        <label class="text-lg text-white">Filter:</label>

        <select name="year" class="bg-secondary shadow-[0_4px_6px_rgba(0,0,0,0.3)] border border-gray-300 hover:shadow-[0_6px_12px_rgba(0,0,0,0.35)] focus:outline-none transition-all duration-300 px-2 py-1 rounded">
            <option value="">All Years</option>
            <?php foreach ($years as $year): ?>
            <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
            <?php endforeach; ?>
        </select>

        <select name="sub" class="bg-secondary shadow-[0_4px_6px_rgba(0,0,0,0.3)] border border-gray-300 hover:shadow-[0_6px_12px_rgba(0,0,0,0.35)] focus:outline-none transition-all duration-300 px-2 py-1 rounded">
            <option value="">All Subjects</option>
            <?php foreach ($subjects as $sub): ?>
            <option value="<?= htmlspecialchars($sub) ?>" <?= $sub == $selectedSub ? 'selected' : '' ?>><?= htmlspecialchars($sub) ?></option>
            <?php endforeach; ?>
        </select>

            <input type="text" name="qp" placeholder="Search QP filename..." value="<?= htmlspecialchars($_GET['qp'] ?? '') ?>" class="placeholder-slate-500 bg-secondary shadow-[0_4px_6px_rgba(0,0,0,0.3)] border border-gray-300 hover:shadow-[0_6px_12px_rgba(0,0,0,0.35)] focus:outline-none transition-all duration-300 px-2 py-1 rounded" style="border-color: var(--primary);" />
            <button type="submit" class="aero text-white px-4 py-1 rounded">Apply</button>
            <a href="?" class="text-sm text-slate-500 hover:text-secondary underline">Clear</a>
        </form>

        <div class="overflow-y-auto max-h-[calc(100vh-200px)] md:overflow-visible">
            <table class="min-w-full table-auto border-collapse bg-blue-900 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100">
            <thead>
                <tr class="bg-secondary text-white">
                <th class="border border-gray-100 px-4 py-2 text-left">Year</th>
                <th class="border border-gray-100 px-4 py-2 text-left">Class/Subject</th>
                <th class="border border-gray-100 px-4 py-2 text-left">QP</th>
                <th class="border border-gray-100 px-4 py-2 text-left">MS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($filteredData) > 0): ?>
                <?php foreach ($filteredData as $row): ?>
                    <tr class="border-b border-gray-100 hover:text-[#A84958] transition">
                    <td class="border border-gray-100 px-4 py-2"><?= htmlspecialchars($row['Year']) ?></td>
                    <td class="border border-gray-100 px-4 py-2"><?= htmlspecialchars($row['Class/Subject']) ?></td>
                    <td class="border border-gray-100 px-4 py-2 truncate max-w-xs">
                        <a target="_blank" class="text-primary underline hover:text-accent" href="<?= htmlspecialchars($row['QP']) ?>">
                            <?= basename(parse_url($row['QP'], PHP_URL_PATH)) ?>
                        </a>
                    </td>
                    <td class="border border-gray-100 px-4 py-2 truncate max-w-xs">
                        <a target="_blank" class="text-primary underline hover:text-accent" href="<?= htmlspecialchars($row['MS']) ?>">
                            <?= basename(parse_url($row['MS'], PHP_URL_PATH)) ?>
                        </a>
                    </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="4" class="text-center py-4 text-gray-400">No matching papers found.</td></tr>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
    </div>
    </main>
    <!-- Socials CTA -->
    <section class="z-20 fixed right-0 top-[50%] hidden md:grid grid-cols-2 bg-secondary gap-1 border border-r-0 rounded-s-lg" dir="ltr" style="border-color: #A84958;">
        <div class="p-1 grid grid-rows-3 gap-2">
            <a href="#"><img id="whatsappicon" class="w-[28px]" src="whatsapp.svg"></a>
            <a href="#"><img id="facebookicon" class="w-[28px]" src="facebook.svg"></a>
            <a href="#"><img id="copylinkicon" class="w-[28px]" src="copylink.svg"></a>
        </div>
        <div class="p-1 border-l border-white flex items-center"><p class="[writing-mode:vertical-lr]">Share Me!</p></div>
    </section>
    <footer class="inline md:hidden flex justify-center items-center bg-secondary gap-1 text-sm border-t bg-blue-900 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10">
        <button class="p-1 hover:text-secondary flex gap-1 items-center justify-center" onclick="toggleTheme()">
            <img class="w-[20px]" src="theme.svg"> Switch Theme
        </button>
        <a href="/examfiles/aboutme.php" class="p-1 hover:text-secondary flex gap-1 items-center justify-center">
            <img class="w-[20px]" src="person.svg"> About Me
        </a>
        <a href="https://buymeacoffee.com/jaazim" target="_blank" class="p-1 hover:text-secondary flex gap-1 items-center justify-center">
            <img class="w-[20px]" src="heart.svg"> Support Me
        </a>
    </footer>
</body>
</html>