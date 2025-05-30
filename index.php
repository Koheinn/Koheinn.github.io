<?php
$username = 'Koheinn';
$userApiUrl = "https://api.github.com/users/$username";
$reposApiUrl = "https://api.github.com/users/$username/repos";

function fetchFromGitHub($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // GitHub API requires a User-Agent header
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Koheinn-Portfolio-App',
        'Accept: application/vnd.github.v3+json'
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "cURL Error: " . curl_error($ch);
        curl_close($ch);
        return null;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        echo "GitHub API returned HTTP status $httpCode";
        return null;
    }

    return json_decode($response, true);
}

$userData = fetchFromGitHub($userApiUrl);
if (!is_array($userData)) {
    die('Failed to fetch user data from GitHub API.');
}

$reposData = fetchFromGitHub($reposApiUrl);
if (!is_array($reposData)) {
    die('Failed to fetch repository data from GitHub API.');
}

$skills = [];

$languageSkillMap = [
    'PHP' => 'PHP',
    'JavaScript' => 'JavaScript',
    'Java' => 'Java',
    'Kotlin' => 'Kotlin',
    'HTML' => 'HTML',
    'CSS' => 'CSS',
    'TypeScript' => 'TypeScript',
    'Python' => 'Python',
    'C++' => 'C++',
    'C#' => 'C#',
    'Go' => 'Go',
    'Ruby' => 'Ruby',
    'Swift' => 'Swift',
    'Objective-C' => 'Objective-C',
    'Shell' => 'Shell Scripting',
    'Dockerfile' => 'Docker',
    'Makefile' => 'Make',
    'C' => 'C',
    'Perl' => 'Perl',
    'Scala' => 'Scala',
    'Rust' => 'Rust',
    'Dart' => 'Dart',
    'Haskell' => 'Haskell',
    'Lua' => 'Lua',
    'Groovy' => 'Groovy',
    'PowerShell' => 'PowerShell',
    'Visual Basic' => 'Visual Basic',
    'Assembly' => 'Assembly',
    'R' => 'R',
    'MATLAB' => 'MATLAB',
    'VHDL' => 'VHDL',
    'Verilog' => 'Verilog',
    'Pascal' => 'Pascal',
    'Fortran' => 'Fortran',
    'COBOL' => 'COBOL',
    'Ada' => 'Ada',
    'Lisp' => 'Lisp',
    'Prolog' => 'Prolog',
    'Scheme' => 'Scheme',
    'Erlang' => 'Erlang',
    'Elixir' => 'Elixir',
    'F#' => 'F#',
    'OCaml' => 'OCaml',
    'Nim' => 'Nim',
    'Crystal' => 'Crystal',
    'Julia' => 'Julia',
    'Hack' => 'Hack',
    'SQL' => 'SQL',
    'PL/SQL' => 'PL/SQL',
    'Tcl' => 'Tcl',
    'Delphi' => 'Delphi',
    'Smalltalk' => 'Smalltalk',
    'VBScript' => 'VBScript',
    'ActionScript' => 'ActionScript',
    'CoffeeScript' => 'CoffeeScript',
    'Common Lisp' => 'Common Lisp',
    'D' => 'D',
    'Emacs Lisp' => 'Emacs Lisp',
    'Forth' => 'Forth',
    'Haxe' => 'Haxe',
    'IDL' => 'IDL',
    'J' => 'J',
    'LabVIEW' => 'LabVIEW',
    'Logo' => 'Logo',
    'ML' => 'ML',
    'Modula-2' => 'Modula-2',
    'OpenCL' => 'OpenCL',
    'OpenEdge ABL' => 'OpenEdge ABL',
    'Racket' => 'Racket',
    'REXX' => 'REXX',
    'Ring' => 'Ring',
    'SAS' => 'SAS',
    'SPARK' => 'SPARK',
    'SPSS' => 'SPSS',
    'Vala' => 'Vala',
    'Zig' => 'Zig'
];

foreach ($reposData as $repo) {
    if (isset($repo['language']) && $repo['language']) {
        $language = $repo['language'];
        if (isset($languageSkillMap[$language])) {
            $skills[$languageSkillMap[$language]] = true;
        } else {
            $skills[$language] = true;
        }
    }
}

$skillsList = array_keys($skills);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($username); ?>'s Portfolio</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0; padding: 0;
      background: #f4f4f4;
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background: #0066cc;
      color: #fff;
      padding: 40px 20px;
      text-align: center;
      flex-shrink: 0;
    }
    header img {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      border: 5px solid #fff;
      margin-bottom: 20px;
      object-fit: cover;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    header h1 {
      margin: 10px 0 5px;
      font-size: 2.5em;
    }
    header p {
      margin: 0;
      font-size: 1.2em;
      font-style: italic;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    main {
      padding: 40px 20px;
      max-width: 1000px;
      margin: auto;
      flex-grow: 1;
      width: 100%;
    }
    h2 {
      border-bottom: 2px solid #0066cc;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .skills {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 40px;
    }
    .skill {
      background: #e0e0e0;
      padding: 10px 15px;
      border-radius: 20px;
      font-size: 1em;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      transition: background 0.3s ease;
      cursor: default;
    }
    .skill:hover {
      background: #c0d4fc;
    }
    .repos {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .repo {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: transform 0.2s, box-shadow 0.2s;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .repo:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .repo a {
      text-decoration: none;
      color: #0066cc;
      font-weight: bold;
      font-size: 1.1em;
      margin-bottom: 10px;
      word-break: break-word;
    }
    .repo p {
      margin: 0;
      font-size: 0.95em;
      color: #555;
      flex-grow: 1;
    }
    footer {
      background: #0066cc;
      color: #fff;
      text-align: center;
      padding: 20px;
      flex-shrink: 0;
      margin-top: 40px;
    }
    @media (max-width: 600px) {
      header h1 {
        font-size: 2em;
      }
      header p {
        font-size: 1em;
      }
      .skill {
        font-size: 0.9em;
        padding: 8px 12px;
      }
      .repo {
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <header>
    <?php if (!empty($userData['avatar_url'])): ?>
      <img src="<?php echo htmlspecialchars($userData['avatar_url']); ?>" alt="Profile Photo" />
    <?php endif; ?>
    <h1><?php echo htmlspecialchars($userData['name'] ?? $username); ?></h1>
    <?php if (!empty($userData['bio'])): ?>
      <p><?php echo htmlspecialchars($userData['bio']); ?></p>
    <?php endif; ?>
  </header>
  <main>
    <section>
      <h2>Skills</h2>
      <div class="skills">
        <?php if (count($skillsList) === 0): ?>
          <p>No detected skills from repositories.</p>
        <?php else: ?>
          <?php foreach ($skillsList as $skill): ?>
            <div class="skill"><?php echo htmlspecialchars($skill); ?></div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
    <section>
      <h2>Repositories</h2>
      <div class="repos">
        <?php if (count($reposData) === 0): ?>
          <p>No repositories found.</p>
        <?php else: ?>
          <?php foreach ($reposData as $repo): ?>
            <div class="repo">
              <a href="<?php echo htmlspecialchars($repo['html_url']); ?>" target="_blank" rel="noopener noreferrer">
                <?php echo htmlspecialchars($repo['name']); ?>
              </a>
              <?php if (!empty($repo['description'])): ?>
                <p><?php echo htmlspecialchars($repo['description']); ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>
  <footer>
    &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($userData['name'] ?? $username); ?>. All rights reserved.
  </footer>
</body>
</html>
