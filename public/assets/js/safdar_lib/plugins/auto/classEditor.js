export function classEditor({ targetSelector }) {
    const input = document.querySelector(targetSelector);
    if (!input) return;
  
    input.addEventListener('input', () => {
      const value = input.value;
      input.className = value;
    });
  }
  