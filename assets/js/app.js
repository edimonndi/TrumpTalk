/* ═══════════════════════════════════════════════
   TrumpTalk — Frontend Engine
   Version 1.0 | Rally Mode Active
   ═══════════════════════════════════════════════ */

'use strict';

/* ─── STATE ──────────────────────────────────── */
let currentMode = 'generate';  // 'generate' | 'transform'
let currentSpeech = '';

/* ─── DOM REFS ───────────────────────────────── */
const modeTabs       = document.querySelectorAll('.mode-tab');
const generateForm   = document.getElementById('generate-section');
const transformForm  = document.getElementById('transform-section');
const generateBtn    = document.getElementById('generate-btn');
const outputPanel    = document.getElementById('output-panel');
const speechOutput   = document.getElementById('speech-output');
const meterFill      = document.getElementById('meter-fill');
const meterValue     = document.getElementById('meter-value');
const wordCount      = document.getElementById('word-count');
const lineCount      = document.getElementById('line-count');
const pauseCount     = document.getElementById('pause-count');
const copyBtn        = document.getElementById('copy-btn');
const dlBtn          = document.getElementById('dl-btn');
const regenerateBtn  = document.getElementById('regenerate-btn');
const intensitySlider = document.getElementById('intensity');
const intensityLabel = document.getElementById('intensity-label');
const toast          = document.getElementById('toast');
const toastMsg       = document.getElementById('toast-msg');

/* ─── MODE TABS ──────────────────────────────── */
modeTabs.forEach(tab => {
  tab.addEventListener('click', () => {
    modeTabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    currentMode = tab.dataset.mode;

    if (currentMode === 'generate') {
      generateForm.style.display = '';
      transformForm.style.display = 'none';
      generateBtn.querySelector('.btn-text').textContent = '🎙️  MAKE AMERICA TALK AGAIN';
    } else {
      generateForm.style.display = 'none';
      transformForm.style.display = '';
      generateBtn.querySelector('.btn-text').textContent = '🔥  TRUMPIFY THIS TEXT';
    }
  });
});

/* ─── INTENSITY LABEL ────────────────────────── */
const intensityLabels = ['Calm', 'Fired Up', 'Rally Mode', 'MAGA MAX', '🔥 UNHINGED'];
intensitySlider.addEventListener('input', () => {
  const v = parseInt(intensitySlider.value);
  intensityLabel.textContent = intensityLabels[v - 1] || 'Rally Mode';
});

/* ─── MAIN GENERATE ──────────────────────────── */
generateBtn.addEventListener('click', async () => {
  const btn = generateBtn;

  // gather options
  const payload = {
    mode:      currentMode,
    topic:     document.getElementById('topic')?.value?.trim() || '',
    rawText:   document.getElementById('raw-text')?.value?.trim() || '',
    speechType: document.getElementById('speech-type')?.value || 'rally',
    intensity:  parseInt(intensitySlider.value),
    usePauses:  document.getElementById('tog-pauses')?.checked ?? true,
    useEmphasis: document.getElementById('tog-emphasis')?.checked ?? true,
    useCrowd:   document.getElementById('tog-crowd')?.checked ?? true,
    useCaps:    document.getElementById('tog-caps')?.checked ?? true,
  };

  if (currentMode === 'generate' && !payload.topic) {
    showToast('⚠️  Give me a topic, folks!', true);
    document.getElementById('topic').focus();
    return;
  }
  if (currentMode === 'transform' && !payload.rawText) {
    showToast('⚠️  Paste some text first!', true);
    document.getElementById('raw-text').focus();
    return;
  }

  // loading state
  btn.classList.add('loading');
  btn.disabled = true;

  try {
    const res = await fetch('api.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });

    if (!res.ok) throw new Error('Server error: ' + res.status);

    const data = await res.json();
    if (data.error) throw new Error(data.error);

    currentSpeech = data.raw;
    renderSpeech(data.html, data.stats);

  } catch (err) {
    showToast('❌  ' + err.message, true);
  } finally {
    btn.classList.remove('loading');
    btn.disabled = false;
  }
});

/* ─── RE-GENERATE ────────────────────────────── */
regenerateBtn?.addEventListener('click', () => generateBtn.click());

/* ─── RENDER SPEECH ──────────────────────────── */
function renderSpeech(html, stats) {
  // reveal panel
  outputPanel.style.display = 'block';
  outputPanel.classList.add('visible', 'fade-in');

  speechOutput.innerHTML = '';

  // typewriter reveal
  const lines = html.split('\n');
  let lineIndex = 0;

  function nextLine() {
    if (lineIndex >= lines.length) {
      // all done — run meter
      const pct = Math.min(100, stats.enthusiasm);
      setTimeout(() => {
        meterFill.style.width = pct + '%';
        meterValue.textContent = pct + '%';
      }, 200);

      wordCount.textContent  = stats.words;
      lineCount.textContent  = stats.lines;
      pauseCount.textContent = stats.pauses;
      return;
    }

    const line = lines[lineIndex++];
    const el = document.createElement('span');
    el.className = 'speech-line';
    el.innerHTML = line === '' ? '<br>' : line;
    speechOutput.appendChild(el);

    // scroll into view
    speechOutput.scrollTop = speechOutput.scrollHeight;

    const delay = line.trim() === '' ? 40 : Math.max(30, Math.min(150, line.length * 3));
    setTimeout(nextLine, delay);
  }

  nextLine();

  // scroll to output
  setTimeout(() => {
    outputPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }, 100);
}

/* ─── COPY ───────────────────────────────────── */
copyBtn?.addEventListener('click', async () => {
  const text = speechOutput.innerText;
  try {
    await navigator.clipboard.writeText(text);
    showToast('✅  Copied! TREMENDOUS!');
    copyBtn.textContent = '✓ COPIED!';
    setTimeout(() => { copyBtn.textContent = '📋 COPY'; }, 2000);
  } catch {
    showToast('❌  Could not copy to clipboard', true);
  }
});

/* ─── DOWNLOAD ───────────────────────────────── */
dlBtn?.addEventListener('click', () => {
  const text = speechOutput.innerText;
  const topic = document.getElementById('topic')?.value || 'speech';
  const blob  = new Blob([text], { type: 'text/plain' });
  const url   = URL.createObjectURL(blob);
  const a     = document.createElement('a');
  a.href      = url;
  a.download  = 'TrumpTalk_' + topic.replace(/\s+/g, '_').slice(0, 30) + '.txt';
  a.click();
  URL.revokeObjectURL(url);
  showToast('💾  Speech downloaded!');
});

/* ─── TOAST ──────────────────────────────────── */
let toastTimer;
function showToast(msg, isError = false) {
  toastMsg.textContent = msg;
  toast.style.borderColor = isError ? '#C8102E' : 'var(--gold)';
  toast.style.color       = isError ? '#FF6B6B' : 'var(--gold)';
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}

/* ─── INIT ANIMATIONS ────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.glass-card').forEach((card, i) => {
    card.style.animationDelay = (i * 0.08) + 's';
    card.classList.add('fade-in');
  });
});
