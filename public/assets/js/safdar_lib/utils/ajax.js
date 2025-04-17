// /utils/ajax.js
export const Ajax = {
  get: async (url) => {
    try {
      const res = await fetch(url);
      if (!res.ok) throw new Error(`GET ${url} failed with status ${res.status}`);
      return await res.json();
    } catch (err) {
      console.error('AJAX GET Error:', err);
      return null;
    }
  },

  post: async (url, data = {}) => {
    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      if (!res.ok) throw new Error(`POST ${url} failed with status ${res.status}`);
      return await res.json();
    } catch (err) {
      console.error('AJAX POST Error:', err);
      return null;
    }
  }
};
