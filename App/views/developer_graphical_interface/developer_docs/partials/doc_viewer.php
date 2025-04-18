<?php
$name = $doc['name'] ?? 'Unknown';
$description = $doc['description'] ?? '';
$usage = $doc['usage'] ?? '';
$functions = $doc['functions'] ?? [];
$exampleHtml = $doc['exampleHtml'] ?? '';
?>

<div class="space-y-6">

  <header>
    <h1 class="text-3xl font-bold text-blue-800 mb-2"><?= htmlspecialchars($name) ?></h1>
    <p class="text-gray-600"><?= htmlspecialchars($description) ?></p>
  </header>

  <section>
    <h2 class="text-xl font-semibold text-gray-700 mb-2">🔧 Usage</h2>
    <p class="bg-white p-3 border rounded text-sm text-gray-800"><?= nl2br(htmlspecialchars($usage)) ?></p>
  </section>

  <section>
    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">⚙️ Configuration (as JSON)</h2>
    <?php foreach ($functions as $index => $func): ?>
      <div class="mb-4 bg-gray-50 p-3 border-l-4 border-blue-500 shadow-sm rounded">
        <div class="font-semibold text-blue-700">Function <?= $index + 1 ?>: <code><?= htmlspecialchars($func['key']) ?></code></div>
        <pre class="text-sm mt-2 bg-white p-2 rounded border overflow-x-auto"><?= json_encode($func['args'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?></pre>
      </div>
    <?php endforeach; ?>
  </section>

  <section>
    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">📦 Simulated JS Integration</h2>
    <pre class="bg-black text-green-300 text-sm rounded p-3 overflow-x-auto">
import Safdar from '../core/safdar.js';
import { Ajax } from '../utils/ajax.js';

(async function () {
  const safdar = new Safdar();
  const config = await Ajax.get(`/developer/config/<?= htmlspecialchars($docName) ?>`);
  
  if (!config || !Array.isArray(config.functions)) return;

  for (const { key, args } of config.functions) {
    const plugin = safdar[key] || safdar.registry[key];
    if (!plugin) {
      try {
        const mod = await import(`../plugins/auto/${key}.js`);
        if (mod[key]) safdar.registerFunction(key, mod[key]);
      } catch (e) { console.warn(e); continue; }
    }
    safdar.call(key, args);
  }
})();
    </pre>
  </section>

  <?php if (!empty($exampleHtml)): ?>
    <?php if (!empty($exampleHtml)): ?>
<section class="mt-8">
  <h2 class="text-xl font-semibold text-gray-700 mb-2">🧪 Live Preview</h2>

  <!-- Live rendered HTML -->
  <div class="preview-area bg-white border border-blue-200 rounded-md p-4 shadow">
    <!-- We'll render exampleHtml here -->
    <?= $exampleHtml ?>
  </div>

  <!-- Optional: Re-run preview button -->
  <button
    onclick="window.runOrchestrator && window.runOrchestrator('<?= $docName ?>')"
    class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"
  >
    🔁 Re-run Config Preview
  </button>

  <!-- HTML source block -->
  <details class="mt-4">
    <summary class="cursor-pointer text-sm text-blue-600 hover:underline">View HTML Source</summary>
    <pre class="bg-gray-100 p-3 rounded mt-2 text-sm"><?= htmlspecialchars($exampleHtml) ?></pre>
  </details>
</section>
<?php endif; ?>

  <?php endif; ?>
</div>
