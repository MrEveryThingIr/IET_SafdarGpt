import Safdar from '../core/safdar.js';
import { Ajax } from '../utils/ajax.js';

(async function () {
  const safdar = new Safdar();

  const pathParts = window.location.pathname.split('/');
  const view = pathParts[pathParts.indexOf('developer') + 1] || 'form_builder';

  const config = await Ajax.get(`/developer/config/${view}`);

  if (!config || !Array.isArray(config.functions)) {
    console.warn('Invalid config from server');
    return;
  }

  config.functions.forEach(({ key, args }) => {
    safdar.call(key, args);
  });
})();
