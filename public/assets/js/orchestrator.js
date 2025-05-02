import registry from './helperRegistry.js';

export async function orchestrate(keywords = []) {
  for (const key of keywords) {
    const config = registry[key];

    if (!config) {
      console.warn(`Unknown scriptHelper keyword: '${key}'`);
      continue;
    }

    try {
      const module = await import(config.module);
      if (typeof module[config.method] === 'function') {
        module[config.method](...config.args);
      } else {
        console.error(`Method '${config.method}' not found in ${config.module}`);
      }
    } catch (err) {
      console.error(`Error loading helper '${key}':`, err);
    }
  }
}
