# 🤝 Contributing to TrumpTalk

> *"Many people are saying this is the most fun open-source project to contribute to. Many, many people."*

First off — **thank you** for even considering this. TrumpTalk started as a weekend idea and a laugh. With the right contributors, it could become the most tremendous satirical web app in the history of the internet. Nobody knows.

---

## 🎯 The Spirit of This Project

TrumpTalk is:
- **Satirical** — political comedy protected as free expression
- **Fun** — if you're not having fun building it, you're doing it wrong
- **Open** — all skill levels welcome, from junior devs to 10x engineers
- **Creditable** — your name goes in the contributors list. Forever. Tremendous.

The core idea, the original concept, the name, and the initial architecture belong to the original author. This project is open so that smart, creative people can make it *even better* — not to have it cloned and relaunched without credit.

---

## 🛠️ How to Contribute

### 1. Fork It
```bash
git clone https://github.com/edimonndi/TrumpTalk.git
cd TrumpTalk
```

### 2. Create a Feature Branch
```bash
git checkout -b feature/your-awesome-feature
```

### 3. Make Your Changes
- Keep the satirical tone consistent
- Follow the existing PHP/JS code style
- Test on at least one local PHP server (XAMPP, AMPPS, or PHP CLI)

### 4. Submit a Pull Request
- Describe what you changed and why it's tremendous
- Include a screenshot or short demo if it's visual
- Reference an open Issue if one exists

---

## 🔥 Most Wanted Contributions

These are the highest-impact improvements. Pick one and you'll be remembered:

### 🤖 AI-Powered Generation *(HIGH IMPACT)*
Replace the template engine in `api.php` with a real LLM call.
- OpenAI GPT-4 / GPT-4o
- Google Gemini API
- Mistral / Ollama (for local/free option)
- Prompt should include system message: *"You are Donald Trump at a campaign rally. Speak in short, punchy lines. Use pauses represented by '...'. Repeat key words. Be tremendous."*

### 🎤 Text-to-Speech *(HIGH IMPACT)*
Make the browser actually *read* the speech aloud.
- Web Speech API (free, built into Chrome/Edge)
- ElevenLabs API for a convincing voice clone (satire use)
- Add a "READ IT ALOUD" button to the output panel

### 📱 React or Vue Frontend *(MEDIUM IMPACT)*
Refactor the vanilla JS into a proper component-based frontend.
- `SpeechGenerator.jsx`
- `SpeechOutput.jsx`
- `IntensityControls.jsx`
- Keep the existing PHP API backend as-is

### 🌍 More Personas *(FUN FACTOR)*
Same engine, different vocabulary packs:
- Joe Biden *("Here's the deal, folks...")*
- Boris Johnson *(crikey, the crumpets of democracy...)*
- Elon Musk *(First principles: words are too expensive)*
- Add a `personas/` folder with JSON vocabulary files

### 📦 Browser Extension *(CREATIVE)*
- Select any text on any webpage
- Right-click → "Trumpify This"
- Popup shows the transformed speech
- Works with the Chrome Extension API

### 🃏 Shareable Speech Cards *(VIRAL POTENTIAL)*
- Generate a styled PNG/JPEG of the speech (like a quote card)
- Use `html2canvas` or a server-side image renderer
- Add social sharing: Twitter/X, WhatsApp, Telegram

### 💾 Speech Database *(ARCHITECTURE)*
- MySQL + login system (or passwordless via email magic link)
- Save your best speeches
- Public "Hall of Fame" — top-voted speeches
- Leaderboard by topic

---

## 📐 Code Style Guidelines

```php
// PHP
// - Use strict types when possible
// - Functions should do one thing
// - Array syntax: short form []
// - Comment anything non-obvious

// JavaScript
// - ES6+ (const/let, arrow functions, async/await)
// - No jQuery — vanilla JS only
// - Keep DOM manipulation in app.js, business logic separate
```

---

## 🐛 Reporting Bugs

Open a GitHub Issue with:
- What you did
- What you expected
- What actually happened (was it tremendous? was it a disaster?)
- Browser + PHP version

---

## 🌟 Contributors

Contributors will be listed here and in a `CREDITS` section.
Your GitHub profile, your pull request, your legacy. Forever.

---

## 🚫 What We Won't Accept

- Hate speech, slurs, or content targeting real individuals maliciously
- Clones or forks that strip attribution
- Spam PRs (low-effort typo fixes dressed as features)
- Removal of the satire disclaimer

---

<div align="center">

*"You want to be part of something tremendous?*
*Something the fake news will never understand?*
*Open a pull request. Do it now. Believe me."*

</div>
