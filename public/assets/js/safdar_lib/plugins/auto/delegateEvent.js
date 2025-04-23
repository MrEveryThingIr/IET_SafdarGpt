export function delegateEvent({
    parentSelector = 'body',
    triggerSelector,
    targetSelector,
    appendToSelector
  }) {
    const parent = document.querySelector(parentSelector);
    if (!parent) {
      console.warn(`[delegateEvent] Parent "${parentSelector}" not found.`);
      return;
    }
  
    parent.addEventListener('click', (e) => {
      if (e.target.matches(triggerSelector)) {
        const target = document.querySelector(targetSelector);
        if (!target) {
          console.warn(`[delegateEvent] Target "${targetSelector}" not found.`);
          return;
        }
  
        const clone = target.cloneNode(true);
        clone.classList.remove('hidden');
  
        let appendTo = null;
  
        // ✅ FIX: handle withinclosest:.wrapper>.inner
        if (appendToSelector.startsWith('withinclosest:')) {
          const raw = appendToSelector.replace('withinclosest:', '');
          const splitIndex = raw.indexOf('>');
          if (splitIndex === -1) {
            console.warn(`[delegateEvent] Invalid withinclosest selector syntax.`);
            return;
          }
  
          const closestSel = raw.slice(0, splitIndex).trim();
          const innerSel = raw.slice(splitIndex + 1).trim();
  
          const container = e.target.closest(closestSel);
          if (container) {
            appendTo = container.querySelector(innerSel);
          }
        }
  
        // ✅ fallback for basic closest:
        else if (appendToSelector.startsWith('closest:')) {
          const closestSel = appendToSelector.replace('closest:', '').trim();
          appendTo = e.target.closest(closestSel);
        }
  
        // ✅ fallback for normal selector
        else {
          appendTo = document.querySelector(appendToSelector);
        }
  
        if (!appendTo) {
          console.warn(`[delegateEvent] Append target not found for: ${appendToSelector}`);
          return;
        }
  
        appendTo.appendChild(clone);
      }
    });
  }
  