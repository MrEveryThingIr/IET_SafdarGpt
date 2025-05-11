import registry from './helperRegistry.js';

export async function orchestrate(keywords = []) {
    for (const key of keywords) {
        const config = registry[key];
        
        if (!config) {
            console.warn(`Unknown helper: '${key}'`);
            continue;
        }

        try {
            const module = await import(config.module);
            const method = module[config.method];
            
            if (typeof method === 'function') {
                method(...config.args);
            } else {
                console.error(`Method ${config.method} not found in ${config.module}`);
            }
        } catch (err) {
            console.error(`Error loading ${key}:`, err);
        }
    }
}