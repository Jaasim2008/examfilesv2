<?php
// Read the CSV file
$filename = 'codes.csv';
$rows = [];

if (($handle = fopen($filename, "r")) !== false) {
    // Read the header row
    $headers = fgetcsv($handle);

    // Read the remaining rows
    while (($data = fgetcsv($handle)) !== false) {
        $rows[] = array_combine($headers, $data);
    }

    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ExamFiles</title>

  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    (function () {
        const savedTheme = localStorage.getItem("theme");
        const defaultTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? "dark" : "light";
        const theme = savedTheme ? savedTheme : defaultTheme;
        document.documentElement.setAttribute("data-theme", theme);
    })();
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
        --border-color: #2b245b;
    }
    :root[data-theme="dark"] {
        --text: #e1dff2;
        --background: #06050d;
        --primary: #a9a3da;
        --secondary: #7d3266;
        --accent: #b7496e;
        --border-color: #a9a3da;
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
    .border-primary {
        border-color: var(--border-color);
    }
    </style>
</head>
<body class="bg-base min-h-screen">
    <main class="p-10 text-lg grid grid-cols-1 gap-6 md:w-4/6">
        <p>Who am I?<br>Im just a 17 yr old in senior high who does a bit of web dev</p>
        <p>Why is this free?<br>One day; when I wanted to find 2025 board papers, i spent 20 mins looking for it and the answer key, also many sites needed me to sign up and verify, it just felt like too much hassle to find two pdfs, so i created this.<br>also the hosting is free, so this is free, you can <a class="text-primary underline" href="#">support me</a> by the way</p>
        <p>Why is this in pink color? Are you a female?<br>no, i just like purple with black (change theme)</p>
        <p>How can contact you?<br><a class="text-primary underline" href="mailto:jazztgblive@gmail.com">jazztgblive@gmail.com</a><br><span class="italic">please report any broken pdfs/links</span></p>
        <p>What is going on with the file names?<br>It is weird because of file indexing, let me explain:<br>the first character (number) is used for denoting which year, like: 0 -> 2025, 1 -> 2024, 2 -> 2023... but: 10 -> 2026, 11 -> 2027...<br>the second character is for which grade, A -> Grade 12 & B -> Grade 10<br>and finally thrid character is for which subject:
            <table class="md:w-2/6 border border-primary table-auto text-sm">
            <thead class="bg-secondary text-base">
                <tr>
                    <th class="border border-primary px-4 py-2">Code</th>
                    <th class="border border-primary px-4 py-2">Subject</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td class="border border-primary px-4 py-2"><?= htmlspecialchars($row['Code']) ?></td>
                    <td class="border border-primary px-4 py-2"><?= htmlspecialchars($row['Subject']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </p>
        <a class="text-primary underline" href="/">< return</a>
    </main>
</body>
</html>
