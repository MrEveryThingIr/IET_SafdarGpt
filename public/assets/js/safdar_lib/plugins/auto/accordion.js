export function accordion({ selector = '.accordion-item' }) {
    document.querySelectorAll(selector).forEach(item => {
      const header = item.querySelector('.accordion-header');
      const body = item.querySelector('.accordion-body');
  
      if (!header || !body) return;
  
      header.addEventListener('click', () => {
        body.classList.toggle('hidden');
      });
    });
  }
  