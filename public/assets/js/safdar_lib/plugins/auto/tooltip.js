export function tooltip({ triggerSelector = '[data-tooltip]', eventType = 'hover' }) {
    const triggers = document.querySelectorAll(triggerSelector);
  
    triggers.forEach(trigger => {
      let tooltipText = trigger.getAttribute('data-tooltip');
      if (!tooltipText) return;
  
      let tooltip = document.createElement('div');
      tooltip.textContent = tooltipText;
      tooltip.className = 'tooltip hidden absolute bg-black text-white text-xs px-2 py-1 rounded z-50';
      document.body.appendChild(tooltip);
  
      const show = (e) => {
        tooltip.classList.remove('hidden');
        const rect = trigger.getBoundingClientRect();
        tooltip.style.top = rect.bottom + window.scrollY + 5 + 'px';
        tooltip.style.left = rect.left + window.scrollX + 'px';
      };
  
      const hide = () => tooltip.classList.add('hidden');
  
      if (eventType === 'hover') {
        trigger.addEventListener('mouseenter', show);
        trigger.addEventListener('mouseleave', hide);
      } else {
        trigger.addEventListener('click', () => {
          tooltip.classList.toggle('hidden');
          show();
        });
      }
    });
  }
  