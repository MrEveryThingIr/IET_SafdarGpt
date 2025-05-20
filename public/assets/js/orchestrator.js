export async function orchestrate(keywords = [], configRegistry = null) {
    const registry = configRegistry || window._JS_HELPER_CONFIG || {};
    console.log('[▶️ orchestrate]', keywords);

    for (const key of keywords) {
        const config = registry[key];

        if (!config) {
            console.warn(`Unknown helper: '${key}'`);
            continue;
        }
        console.log(`Loading module ${config.module}...`);


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

// 🆕 Boot from remote endpoint
export async function bootDynamicJsHelpers(jsonApiUrl) {
    try {
        const response = await fetch(jsonApiUrl);
        const config = await response.json();
        console.log('[✔️ fetched config]', config); // 👈 Add this
        const keys = Object.keys(config);
        window._JS_HELPER_CONFIG = config; // for dev inspection
        orchestrate(keys, config);
    } catch (err) {
        console.error('[orchestrator] Failed to boot dynamic JS helpers:', err);
    }
}
