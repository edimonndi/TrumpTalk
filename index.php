<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title>TrumpTalk — Rally Speech Generator | Make America Talk Again</title>
    <meta name="description"
        content="Generate powerful, rally-style Trump speeches on any topic. Voice-optimized with natural pauses, crowd energy, and authentic Trumpisms. Make America Talk Again!">
    <meta name="keywords" content="trump speech generator, rally speech, political speech maker, MAGA, trumptalk">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="TrumpTalk — Make America Talk Again">
    <meta property="og:description"
        content="Generate Donald Trump-style rally speeches on any topic. Voice-optimized. Tremendous.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/TrumpTalk/assets/img/og-preview.jpg">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body>

    <!-- ── HEADER ───────────────────────────── -->
    <header class="site-header" role="banner">
        <div class="flag-bar" aria-hidden="true">
            <div class="flag-stripe"></div>
            <div class="flag-stripe"></div>
            <div class="flag-stripe"></div>
            <div class="flag-stripe"></div>
            <div class="flag-stripe"></div>
            <div class="flag-stripe"></div>
            <div class="flag-stripe"></div>
        </div>

        <h1 class="site-logo">TrumpTalk</h1>
        <p class="site-tagline">Make America Talk Again</p>

        <div class="stars-row" aria-hidden="true">
            <span>★</span><span>★</span><span>★</span>
            <span>★</span><span>★</span><span>★</span><span>★</span>
            <span>★</span><span>★</span><span>★</span>
        </div>
    </header>

    <!-- ── MAIN ─────────────────────────────── -->
    <main class="container" id="main-content">

        <!-- MODE TABS -->
        <div class="mode-tabs" role="tablist" aria-label="Speech Mode">
            <button class="mode-tab active" data-mode="generate" role="tab" aria-selected="true" id="tab-generate">
                🎙️ GENERATE SPEECH
            </button>
            <button class="mode-tab" data-mode="transform" role="tab" aria-selected="false" id="tab-transform">
                🔥 TRUMPIFY TEXT
            </button>
        </div>

        <!-- ── INPUT CARD ──────────────────────── -->
        <section class="glass-card" aria-labelledby="form-heading">
            <h2 class="card-title"><span class="icon">📢</span> RALLY COMMAND CENTER</h2>

            <!-- GENERATE SECTION -->
            <div id="generate-section">
                <div class="form-group">
                    <label class="form-label" for="topic">Speech Topic</label>
                    <input class="form-input" type="text" id="topic" name="topic"
                        placeholder="e.g. The Economy, Immigration, China, The Fake News..." autocomplete="off"
                        maxlength="120">
                </div>

                <div class="form-group">
                    <label class="form-label" for="speech-type">Speech Style</label>
                    <select class="form-select" id="speech-type" name="speech-type">
                        <option value="rally">🏟️ Campaign Rally</option>
                        <option value="press">📹 Press Conference</option>
                        <option value="tweet">📱 Twitter-Style Rant</option>
                        <option value="debate">⚡ Debate Mode</option>
                    </select>
                </div>
            </div>

            <!-- TRANSFORM SECTION (hidden by default) -->
            <div id="transform-section" style="display:none;">
                <div class="form-group">
                    <label class="form-label" for="raw-text">Paste Your Text</label>
                    <textarea class="form-textarea" id="raw-text" name="raw-text"
                        placeholder="Paste any sentence or paragraph here and we'll TRUMPIFY it... Believe me, it'll be tremendous..."
                        rows="5"></textarea>
                </div>
            </div>

            <!-- OPTIONS -->
            <div class="form-group">
                <label class="form-label">Voice Options</label>
                <div class="options-grid">

                    <label class="option-item" for="tog-pauses">
                        <div>
                            <div class="option-label">Natural Pauses</div>
                            <div class="option-sub">Insert "..." for dramatic effect</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="tog-pauses" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </label>

                    <label class="option-item" for="tog-emphasis">
                        <div>
                            <div class="option-label">Word Emphasis</div>
                            <div class="option-sub">Highlight key power words</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="tog-emphasis" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </label>

                    <label class="option-item" for="tog-crowd">
                        <div>
                            <div class="option-label">Crowd Energizers</div>
                            <div class="option-sub">Add rally chants & crowd lines</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="tog-crowd" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </label>

                    <label class="option-item" for="tog-caps">
                        <div>
                            <div class="option-label">CAPS Mode</div>
                            <div class="option-sub">SHOUT the important stuff</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="tog-caps" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </label>

                </div>
            </div>

            <!-- INTENSITY -->
            <div class="form-group">
                <label class="form-label" for="intensity">
                    Intensity Level —
                    <span id="intensity-label" style="color:var(--gold);font-weight:800;">Rally Mode</span>
                </label>
                <div class="intensity-wrap">
                    <input type="range" id="intensity" name="intensity" min="1" max="5" value="3" step="1">
                    <div class="intensity-labels">
                        <span>Calm</span>
                        <span>Fired Up</span>
                        <span>Rally Mode</span>
                        <span>MAGA MAX</span>
                        <span>🔥 UNHINGED</span>
                    </div>
                </div>
            </div>

            <!-- GENERATE BUTTON -->
            <div class="btn-row">
                <button class="btn btn-primary" id="generate-btn" type="button" aria-live="polite">
                    <div class="spinner" aria-hidden="true"></div>
                    <span class="btn-text">🎙️ &nbsp; MAKE AMERICA TALK AGAIN</span>
                </button>
            </div>
        </section>

        <!-- ── OUTPUT CARD ─────────────────────── -->
        <section class="glass-card" id="output-panel" aria-live="polite" aria-label="Generated Speech">

            <div class="output-header">
                <h2 class="card-title" style="margin-bottom:0;">
                    <span class="icon">📜</span> THE SPEECH
                </h2>
                <div class="output-badge">
                    <span class="dot" aria-hidden="true"></span>
                    LIVE FROM THE RALLY
                </div>
            </div>

            <!-- Speech Text -->
            <div id="speech-output" role="region" aria-label="Generated speech text"></div>

            <!-- Enthusiasm Meter -->
            <div class="meter-wrap">
                <div class="meter-label">
                    Crowd Enthusiasm
                    <span id="meter-value">0%</span>
                </div>
                <div class="meter-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="meter-fill" id="meter-fill"></div>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-row" aria-label="Speech statistics">
                <div class="stat-pill">
                    📝 Words: <strong id="word-count">—</strong>
                </div>
                <div class="stat-pill">
                    📏 Lines: <strong id="line-count">—</strong>
                </div>
                <div class="stat-pill">
                    ⏸️ Pauses: <strong id="pause-count">—</strong>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-row">
                <button class="btn btn-gold" id="copy-btn" type="button" aria-label="Copy speech to clipboard">
                    📋 COPY
                </button>
                <button class="btn btn-secondary" id="dl-btn" type="button" aria-label="Download speech as text file">
                    💾 DOWNLOAD
                </button>
                <button class="btn btn-secondary" id="regenerate-btn" type="button" aria-label="Generate a new version">
                    🔄 ANOTHER ONE
                </button>
            </div>

        </section>

    </main>

    <!-- ── FOOTER ────────────────────────────── -->
    <footer class="site-footer" role="contentinfo">
        <p>★ TrumpTalk &copy; <?php echo date('Y'); ?> &nbsp;|&nbsp; Make America Talk Again ★</p>
        <p style="margin-top:6px;font-size:10px;opacity:0.5;">
            Satire &amp; Entertainment Only. Not affiliated with any political party or candidate.
        </p>
    </footer>

    <!-- ── TOAST NOTIFICATION ────────────────── -->
    <div class="toast" id="toast" role="alert" aria-live="assertive">
        <span id="toast-msg"></span>
    </div>

    <!-- ── SCRIPTS ───────────────────────────── -->
    <script src="assets/js/app.js" defer></script>

</body>

</html>