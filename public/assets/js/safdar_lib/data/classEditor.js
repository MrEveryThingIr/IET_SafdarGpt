export function classEditor({ targetSelector, classes }) {
    const target = document.querySelector(targetSelector);
    if (!target) return;
  
    target.addEventListener('input', () => {
      console.log('Class changed:', target.value);
      // Optional: live preview?
    });
  }
  