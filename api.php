<?php
/**
 * TrumpTalk — Speech Generation API
 * Voice-Optimized Rally Speech Engine
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$mode = $input['mode'] ?? 'generate';
$topic = trim($input['topic'] ?? '');
$rawText = trim($input['rawText'] ?? '');
$speechType = $input['speechType'] ?? 'rally';
$intensity = max(1, min(5, intval($input['intensity'] ?? 3)));
$usePauses = $input['usePauses'] ?? true;
$useEmphasis = $input['useEmphasis'] ?? true;
$useCrowd = $input['useCrowd'] ?? true;
$useCaps = $input['useCaps'] ?? true;

/* ═══════════════════════════════════════════════
   TRUMP VOCABULARY & PATTERN LIBRARY
   ═══════════════════════════════════════════════ */

$openers = [
    "Look...\nLook, I'm going to be honest with you...\nI'm going to tell you something\nthe fake news media\nwill NEVER report.",
    "Nobody...\nAND I MEAN NOBODY...\nknows more about [TOPIC] than me.\nNobody.",
    "We're going to talk about [TOPIC] tonight...\nAnd believe me, folks...\nwhat I'm about to tell you\nis going to BLOW... YOUR... MIND.",
    "You know what?\nThe people in Washington...\nthey don't want me to talk about [TOPIC].\nThat's exactly why\nI HAVE to talk about [TOPIC].",
    "Let me tell you something...\nI've been saying this\nfor YEARS.\nFor years!\nAnd nobody listened.\nNobody.",
    "Folks...\nthe radical left...\nthey are TERRIFIED\nof what I'm about to say.",
    "My whole life...\nmy whole beautiful life...\nI've been fighting for the American people.\nAnd tonight\nwe're going to talk about [TOPIC].",
];

$superlatives = [
    'tremendous',
    'incredible',
    'beautiful',
    'perfect',
    'fantastic',
    'massive',
    'unbelievable',
    'phenomenal',
    'spectacular',
    'the best',
    'like nobody\'s ever seen',
    'greater than ever before',
    'bigly',
    'very very great',
];

$attackPhrases = [
    "The fake news won't tell you this...",
    "Crooked politicians... they don't want this...",
    "The radical left is FURIOUS right now...",
    "China... they're watching us right now...",
    "The deep state... they're terrified...",
    "The lamestream media... they're going CRAZY...",
    "The globalists... they hate what I'm about to say...",
];

$selfBoasts = [
    "And I did it... I did it like nobody else could.",
    "I built the greatest [TOPIC] system... the greatest ever.",
    "People come up to me, strong men, tough guys,\nwith tears streaming down their face,\nand they say, 'Sir... sir, thank you.'",
    "I know more about [TOPIC] than the generals.\nMore than the experts.\nMore than anybody.",
    "I did more for [TOPIC] in four years\nthan any other president\ndid in HISTORY.",
    "Everyone's saying it.\nEveryone.\nEven the people who hate me\nare saying it.",
];

$crowdEnergizers = [
    "Are you with me?\nAre... you... WITH... ME?!",
    "Say it with me...\nUSA! USA! USA!",
    "This is the greatest crowd.\nI've never seen so many people.\nNever.\nThe fake news won't show these cameras turning around...\nbut look at this crowd!",
    "We love this country.\nWe LOVE this country.\nAnd it's time to take it BACK.",
    "Lock them up!\nLock... them... UP!",
    "Who's going to pay for it?\nWHO?!\nThat's right... somebody else!",
];

$closers = [
    "Together...\nwe are going to WIN.\nWe are going to WIN BIG.\nBigger than you've ever seen.\nAnd we are going to\nMAKE AMERICA GREAT AGAIN!",
    "November is coming...\nand when it comes...\nthey're going to remember this moment.\nThis BEAUTIFUL moment.\nWe did it together.\nWe saved this country.",
    "God bless you.\nGod bless our military.\nGod bless the United States of America.\nAnd remember...\nLet's Make America Great Again!\nThank you!\nI LOVE YOU!",
    "The best is yet to come...\nThe absolute BEST is yet to come.\nDon't let them tell you otherwise.\nWe are going to WIN.\nWe always WIN.",
];

$topicStatements = [
    "The [TOPIC] situation...\nit's a disaster.\nA TOTAL disaster.\nOur country has never seen anything like it.",
    "When I was in office...\n[TOPIC] flourished.\nIt flourished like never before.\nAnd then they ruined it.\nThey RUINED it.",
    "I have a plan for [TOPIC].\nA beautiful plan.\nA PERFECT plan.\nAnd I'm going to implement it\non day one.\nDay. One.",
    "Other countries...\nthey're laughing at us\nbecause of [TOPIC].\nChina is laughing.\nRussia is laughing.\nEven the small countries...\nthey're laughing.\nNot anymore.",
    "Think about what we could do with [TOPIC].\nJust THINK about it.\nIt's going to be so good.\nSo... incredibly... good.",
    "The numbers on [TOPIC]...\nyou know what they are?\nThey're incredible.\nBest numbers we've ever had.\nEVER.",
];

$transitions = [
    "And by the way...",
    "But here's the thing...",
    "Let me tell you...",
    "And I've always said...",
    "You know what's crazy?",
    "Nobody talks about this.\nNobody.",
    "And another thing...",
    "By the way...\nby the WAY...",
];

/* ═══════════════════════════════════════════════
   SPEECH BUILDER
   ═══════════════════════════════════════════════ */

function replaceTopic($text, $topic)
{
    $label = strtoupper(!empty($topic) ? $topic : 'THIS GREAT COUNTRY');
    return str_replace('[TOPIC]', $label, $text);
}

function applyVoiceOptimization($lines, $intensity, $usePauses, $useEmphasis, $useCaps)
{
    $optimized = [];

    $capsWords = [
        'never',
        'nobody',
        'best',
        'worst',
        'disaster',
        'tremendous',
        'incredible',
        'beautiful',
        'catastrophe',
        'win',
        'winning',
        'failed',
        'rigged',
        'fake',
        'total',
        'america',
        'great',
        'again',
        'massive',
        'huge',
        'perfect',
    ];
    $pattern = '/\b(' . implode('|', $capsWords) . ')\b/i';

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '') {
            $optimized[] = '';
            continue;
        }

        // Apply CAPS emphasis on key Trump words
        if ($useCaps && $intensity >= 3) {
            $line = preg_replace_callback($pattern, function ($m) {
                return strtoupper($m[0]);
            }, $line);
        }

        // Extra line breaks on exclamations at high intensity
        if ($usePauses && $intensity >= 4) {
            $line = preg_replace('/(\!+)\s+/', "$1\n", $line);
        }

        $optimized[] = $line;
    }

    return $optimized;
}

function buildSpeech($topic, $speechType, $intensity, $usePauses, $useEmphasis, $useCrowd, $useCaps)
{
    global $openers, $topicStatements, $attackPhrases, $selfBoasts, $crowdEnergizers, $closers, $transitions;

    $parts = [];

    // 1. OPENER
    $opener = $openers[array_rand($openers)];
    $opener = replaceTopic($opener, $topic);
    $parts[] = $opener;
    $parts[] = '';

    // 2. ATTACK
    if ($intensity >= 2) {
        $attack = $attackPhrases[array_rand($attackPhrases)];
        $parts[] = $attack;
        $parts[] = '';
    }

    // 3. TOPIC STATEMENT 1
    $stmt1 = $topicStatements[array_rand($topicStatements)];
    $stmt1 = replaceTopic($stmt1, $topic);
    $parts[] = $stmt1;
    $parts[] = '';

    // 4. TRANSITION + TOPIC STATEMENT 2
    $trans = $transitions[array_rand($transitions)];
    $parts[] = $trans;
    $parts[] = '';

    $remainingStatements = $topicStatements;
    $stmt2 = $remainingStatements[array_rand($remainingStatements)];
    $stmt2 = replaceTopic($stmt2, $topic);
    $parts[] = $stmt2;
    $parts[] = '';

    // 5. SELF BOAST
    $boast = $selfBoasts[array_rand($selfBoasts)];
    $boast = replaceTopic($boast, $topic);
    $parts[] = $boast;
    $parts[] = '';

    // 6. ATTACK 2 (high intensity)
    if ($intensity >= 3) {
        $attack2 = $attackPhrases[array_rand($attackPhrases)];
        $parts[] = $attack2;
        $parts[] = '';
    }

    // 7. CROWD ENERGIZER
    if ($useCrowd) {
        $crowd = $crowdEnergizers[array_rand($crowdEnergizers)];
        $parts[] = $crowd;
        $parts[] = '';
    }

    // 8. EXTRA INTENSITY BLOCK
    if ($intensity >= 4) {
        $extra = $topicStatements[array_rand($topicStatements)];
        $extra = replaceTopic($extra, $topic);
        $trans2 = $transitions[array_rand($transitions)];
        $parts[] = $trans2;
        $parts[] = '';
        $parts[] = $extra;
        $parts[] = '';
    }

    // 9. CLOSER
    $closer = $closers[array_rand($closers)];
    $parts[] = $closer;

    // Flatten to lines
    $allLines = [];
    foreach ($parts as $part) {
        $sublines = explode("\n", $part);
        foreach ($sublines as $sl) {
            $allLines[] = $sl;
        }
    }

    // Voice optimization pass
    $allLines = applyVoiceOptimization($allLines, $intensity, $usePauses, $useEmphasis, $useCaps);

    return $allLines;
}

function transformText($rawText, $intensity, $usePauses, $useEmphasis, $useCaps)
{
    global $attackPhrases, $transitions, $selfBoasts;

    $sentences = preg_split('/(?<=[.!?])\s+/', trim($rawText));

    $trumpified = [];

    foreach ($sentences as $i => $s) {
        $s = trim($s);
        if (empty($s))
            continue;

        // Inject Trump-isms randomly
        if ($i % 3 === 0 && $intensity >= 2) {
            $trumpified[] = $transitions[array_rand($transitions)];
            $trumpified[] = '';
        }

        // Make more dramatic — break at conjunctions
        $s = preg_replace('/\s+(and|but|because|so|which)\s+/i', "\n$1 ", $s);

        // Replace bland adjectives with Trump superlatives
        $replacements = [
            '/\bgood\b/i' => 'TREMENDOUS',
            '/\bbad\b/i' => 'a TOTAL DISASTER',
            '/\bbig\b/i' => 'MASSIVE',
            '/\bimportant\b/i' => 'incredibly, incredibly important',
            '/\bgreat\b/i' => 'the GREATEST ever',
            '/\bpeople\b/i' => 'GREAT people',
            '/\bcountry\b/i' => 'GREAT country',
            '/\bplan\b/i' => 'BEAUTIFUL plan',
            '/\bproblem\b/i' => 'DISASTER',
            '/\bwork\b/i' => 'HARD work, believe me',
            '/\bnever\b/i' => 'NEVER, EVER',
            '/\balways\b/i' => 'ALWAYS... always',
        ];

        foreach ($replacements as $pattern => $replacement) {
            $s = preg_replace($pattern, $replacement, $s);
        }

        // Add pause before terminal punctuation
        if ($usePauses && $intensity >= 2) {
            $s = preg_replace('/\.\s*$/', '...', $s);
        }

        $trumpified[] = $s;

        // Insert attack phrase every 4 sentences
        if ($i > 0 && $i % 4 === 0 && $intensity >= 3) {
            $trumpified[] = '';
            $trumpified[] = $attackPhrases[array_rand($attackPhrases)];
        }

        $trumpified[] = '';
    }

    // Add a rousing close
    $trumpified[] = "Believe me...";
    $trumpified[] = "NOBODY does it better.";
    $trumpified[] = "Nobody.";

    return applyVoiceOptimization($trumpified, $intensity, $usePauses, $useEmphasis, $useCaps);
}

/* ═══════════════════════════════════════════════
   HTML RENDERER — Voice-Optimized Output
   ═══════════════════════════════════════════════ */

function renderHTML($lines, $useEmphasis)
{
    $html = [];

    $emphasisWords = [
        'NEVER',
        'NOBODY',
        'BEST',
        'WORST',
        'DISASTER',
        'TREMENDOUS',
        'INCREDIBLE',
        'WIN',
        'WINNING',
        'FAKE',
        'TOTAL',
        'AMERICA',
        'GREAT',
        'AGAIN',
        'MASSIVE',
        'PERFECT',
        'CATASTROPHE',
        'UNBELIEVABLE',
        'RIGGED',
        'BEAUTIFUL',
        'PHENOMENAL',
        'EVER',
        'ALWAYS',
    ];

    foreach ($lines as $line) {
        if (trim($line) === '') {
            $html[] = '';
            continue;
        }

        $escaped = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');

        // Mark pauses (...)
        $escaped = preg_replace('/\.\.\./', '<span class="pause">...</span>', $escaped);

        // Mark ALL-CAPS emphasis words
        if ($useEmphasis) {
            foreach ($emphasisWords as $w) {
                $escaped = preg_replace(
                    '/\b' . preg_quote($w, '/') . '\b/',
                    '<span class="emphasis">' . $w . '</span>',
                    $escaped
                );
            }

            // Extra loud for exclamation patterns
            $escaped = preg_replace(
                '/([A-Z]{4,})(\!+)/',
                '<span class="loud">$1$2</span>',
                $escaped
            );
        }

        $html[] = $escaped;
    }

    return implode("\n", $html);
}

/* ═══════════════════════════════════════════════
   STATS CALCULATOR
   ═══════════════════════════════════════════════ */

function calcStats($lines, $intensity)
{
    $raw = implode("\n", $lines);
    $words = str_word_count(strip_tags($raw));
    $nonEmpty = array_filter($lines, fn($l) => trim($l) !== '');
    $pauses = substr_count($raw, '...');
    $enthusiasm = min(100, 50 + ($intensity * 8) + ($pauses * 2) + intval($words / 10));

    return [
        'words' => $words,
        'lines' => count($nonEmpty),
        'pauses' => $pauses,
        'enthusiasm' => $enthusiasm,
    ];
}

/* ═══════════════════════════════════════════════
   EXECUTE
   ═══════════════════════════════════════════════ */

try {
    if ($mode === 'generate') {
        if (empty($topic))
            throw new Exception('Topic is required');
        $lines = buildSpeech($topic, $speechType, $intensity, $usePauses, $useEmphasis, $useCrowd, $useCaps);
    } else {
        if (empty($rawText))
            throw new Exception('Text is required');
        $lines = transformText($rawText, $intensity, $usePauses, $useEmphasis, $useCaps);
    }

    $html = renderHTML($lines, $useEmphasis);
    $stats = calcStats($lines, $intensity);
    $raw = implode("\n", $lines);

    echo json_encode([
        'success' => true,
        'html' => $html,
        'raw' => $raw,
        'stats' => $stats,
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
