export function dropdown({ triggerSelector, dropdownSelector, eventType = 'click' }) {
  const trigger = document.querySelector(triggerSelector);
  const dropdown = document.querySelector(dropdownSelector);
  if (!trigger || !dropdown) return;

  trigger.addEventListener(eventType, (e) => {
    dropdown.classList.toggle('hidden');
  });

  document.addEventListener('click', (e) => {
    if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('hidden');
    }
  });
}
