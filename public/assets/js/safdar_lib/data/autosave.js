import { Ajax } from '../utils/ajax.js';

export function autosave({ formSelector, url, interval = 3000 }) {
  const form = document.querySelector(formSelector);
  if (!form) return;

  setInterval(() => {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    Ajax.post(url, data).then(res => {
      console.log('Autosaved:', res);
    });
  }, interval);
}
