// /assets/js/helpers/clockHelper.js

/**
 * Initialize Clock Display
 *
 * @param {string} targetSelector - DOM selector to attach clock UI
 * @param {Object} options - Optional configuration
 */
export function initClockDisplay(targetSelector, options = {}) {
  const target = document.querySelector(targetSelector);

  if (!target) {
    console.warn(`[clockDisplay] No element found for selector: ${targetSelector}`);
    return;
  }

  const config = {
    showLabels: true,
    ...options
  };

  function updateClock() {
    const now = new Date();
    const parts = {
      year: now.getFullYear(),
      month: String(now.getMonth() + 1).padStart(2, '0'),
      day: String(now.getDate()).padStart(2, '0'),
      hour: String(now.getHours()).padStart(2, '0'),
      minute: String(now.getMinutes()).padStart(2, '0'),
      second: String(now.getSeconds()).padStart(2, '0')
    };

    target.innerHTML = `
      <div class="flex flex-wrap justify-center gap-4 text-center text-white font-mono text-lg md:text-2xl">
        ${Object.entries(parts).map(([label, value]) => `
          <div class="transition-all duration-300 ease-in-out transform hover:scale-110 p-2 rounded bg-gray-800 shadow">
            <div>${value}</div>
            ${config.showLabels ? `<div class="text-xs text-gray-400">${label}</div>` : ''}
          </div>
        `).join('')}
      </div>
    `;
  }

  updateClock();
  setInterval(updateClock, 1000);
}
