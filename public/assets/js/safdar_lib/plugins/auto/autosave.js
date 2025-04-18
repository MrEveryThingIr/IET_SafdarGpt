export function autosave({ formSelector, url }) {
    const form = document.querySelector(formSelector);
    if (!form) return;
  
    form.addEventListener('input', () => {
      const data = new FormData(form);
      fetch(url, {
        method: 'POST',
        body: data,
      });
    });
  }
  