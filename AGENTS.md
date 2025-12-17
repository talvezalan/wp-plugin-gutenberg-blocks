# Project Guidelines: ACF Blocks Plugin

## 1. Environment & Setup
- **Reqs**: Node 18+, WP 6.2+, ACF Pro 6.6+ active.
- **Install**: `npm install` -> `npm run tailwind:build`.
- **Dev**: `npm run dev` (Watch mode).
- **Build**: `npm run build:plugin` -> Generates `acf-blocks-starter-vX.X.X.zip` (excludes src/dev files).

## 2. Block Development Standards (Strict)

### ACF Configuration (v3)
`block.json` MUST use `blockVersion: 3` inside `acf` key.
```json
{
  "apiVersion": 3,
  "acf": { "mode": "preview", "renderTemplate": "render.php", "blockVersion": 3 }
}
```

### HTML & Accessibility
- **Semantic HTML**: `nav`, `header`, `main`, `section`, `article`, `aside`, `footer` mandatory.
- **Structure**: Logical hierarchy (h1 -> h2 -> h3). No div soup.
- **Lists**: Use `ul`/`ol` for lists, not divs.

### CSS (Tailwind)
- **Prefix**: ALL classes MUST have `acfb-` prefix (e.g., `acfb-flex`, `acfb-bg-primary-500`).
- **Extensions**: No external .css files. Use `tailwind.config.js` for theme customization.
- **Forbidden**: Inline styles `style="..."`, non-prefixed classes.

### JavaScript
- **Vanilla Only**: No jQuery, no frameworks (React/Vue/etc) inside blocks unless approved.
- **Loading**: Place `blockname.js` alongside `render.php`. Auto-enqueued.
- **Pattern**: IIFE + DOMContentLoaded check.
```javascript
(function() {
  const init = () => { /* implementation */ };
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
```

### Schema.org
- **Usage**: Only for structured data (FAQ, Review, HowTo). Not for decorative blocks.
- **Impl**: Use ACF Toggle `enable_schema` -> `acfb_register_schema()` in `render.php`.

## 3. Workflow Summary
1. Create block in `blocks/`.
2. `block.json` (v3) + `render.php` + `fields.php` + `style.css` (optional) + `script.js` (vanilla).
3. `npm run tailwind:watch` while developing.
4. `npm run build:plugin` for release.
