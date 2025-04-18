// orchestrator.js
import Safdar from '../core/safdar.js';
import { Ajax } from '../utils/ajax.js';

window.runOrchestrator = async function(view = null) {
  const safdar = new Safdar();
  view = view || window.location.pathname.split('/').pop() || 'form_builder';

  const config = await Ajax.get(`/developer/config/${view}`);
  if (!config || !Array.isArray(config.functions)) {
    console.warn('Invalid config from server');
    return;
  }

  for (const { key, args } of config.functions) {
    const exists = typeof safdar[key] === 'function' || safdar.registry[key];
    if (!exists) {
      try {
        const pluginModule = await import(`../plugins/auto/${key}.js`);
        if (pluginModule[key]) {
          safdar.registerFunction(key, pluginModule[key]);
        } else {
          console.warn(`Plugin "${key}" loaded but no matching export found.`);
          continue;
        }
      } catch (err) {
        console.warn(`Plugin "${key}" not found in /plugins/auto/`, err);
        continue;
      }
    }

    safdar.call(key, args);
  }
};

// ✅ Run initially
window.runOrchestrator();
