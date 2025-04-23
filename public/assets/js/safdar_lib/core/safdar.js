class Safdar {
  constructor() {
    this.registry = {};         // Custom/utility functions
    this.indexMap = new Map();  // For managing dynamic clone indices
  }

  call(name, args = {}) {
    const fn = this.registry[name] || this[name];
  
    if (typeof fn !== 'function') {
      console.warn(`Safdar: Function "${name}" not found.`);
      return;
    }
  
    // 🔁 If batch of configs is passed as array, run each
    if (Array.isArray(args)) {
      args.forEach(config => fn.call(this, config));
    } else {
      fn.call(this, args);
    }
  }
  
  
  registerFunction(name, fn) {
    if (typeof fn === 'function') {
      this.registry[name] = fn;
    }
  }

  bindEvent({ triggerSelector, targetSelector, eventType = 'click', action }) {
    const triggers = document.querySelectorAll(triggerSelector);
    const target = targetSelector ? document.querySelector(targetSelector) : null;

    triggers.forEach(trigger => {
      trigger.addEventListener(eventType, (event) => {
        action?.({ trigger, target, event });
      });
    });
  }

  delegateEvent({ parentSelector = 'body', triggerSelector, eventType = 'click', targetSelector, appendToSelector }) {
    const parent = document.querySelector(parentSelector);
    if (!parent) return;
  
    parent.addEventListener(eventType, (e) => {
      if (!e.target.matches(triggerSelector)) return;
  
      const target = document.querySelector(targetSelector);
      if (!target) {
        console.warn(`[delegateEvent] Target "${targetSelector}" not found.`);
        return;
      }
  
      const clone = target.cloneNode(true);
      clone.classList.remove('hidden');
  
      let appendTo = null;
  
      // ✅ Handle withinclosest: syntax
      if (appendToSelector.startsWith('withinclosest:')) {
        const raw = appendToSelector.replace('withinclosest:', '');
        const splitIndex = raw.indexOf('>');
        if (splitIndex === -1) {
          console.warn(`[delegateEvent] Invalid withinclosest syntax: "${appendToSelector}"`);
          return;
        }
  
        const closestSel = raw.slice(0, splitIndex).trim();
        const innerSel = raw.slice(splitIndex + 1).trim();
  
        const container = e.target.closest(closestSel);
        if (container) {
          appendTo = container.querySelector(innerSel);
        }
      }
  
      // ✅ Handle closest:
      else if (appendToSelector.startsWith('closest:')) {
        const closestSel = appendToSelector.replace('closest:', '').trim();
        const closestElem = e.target.closest(closestSel);
        if (closestElem) {
          appendTo = closestElem.querySelector('.option-container');
        }
      }
  
      // ✅ Normal fallback
      else {
        try {
          appendTo = document.querySelector(appendToSelector);
        } catch (err) {
          console.warn(`[delegateEvent] Invalid selector: ${appendToSelector}`);
          return;
        }
      }
  
      if (!appendTo) {
        console.warn(`[delegateEvent] Append target not found for: ${appendToSelector}`);
        return;
      }
  
      appendTo.appendChild(clone);
  
      const fieldsets = document.querySelectorAll('.selectoption');
      const currentIndex = [...fieldsets].indexOf(e.target.closest('.selectoption'));
  
      clone.querySelectorAll('[name]').forEach(input => {
        input.name = input.name.replace(/\[\]/, `[${currentIndex}][]`);
      });
    });
  }
  
  

  cloneElement({
    triggerSelector,
    targetSelector,
    appendToSelector,
    eventType = 'click',
    contextKey,
    maxClones = null,
    renamePattern = '[__index__][]',
    resetOnClone = false,
    afterCloneCallback = null
  }) {
    this.bindEvent({
      triggerSelector,
      targetSelector,
      eventType,
      action: ({ trigger, target }) => {
        if (!target) return;
        const clone = target.cloneNode(true);
        clone.classList.remove('hidden');

        const appendTo = appendToSelector.startsWith('closest:')
          ? trigger.closest(appendToSelector.replace('closest:', ''))?.querySelector('.option-container')
          : document.querySelector(appendToSelector);

        if (!appendTo) {
          console.warn(`Safdar: appendTo not found for ${appendToSelector}`);
          return;
        }

        const count = (this.indexMap.get(contextKey) ?? 0);
        if (maxClones !== null && count >= maxClones) return;

        this.indexMap.set(contextKey, count + 1);

        clone.querySelectorAll('[name]').forEach(input => {
          input.name = input.name.replace(/\[\]/g, renamePattern.replace('__index__', count));
          if (resetOnClone) input.value = '';
        });

        clone.dataset.contextIndex = count;
        appendTo.appendChild(clone);

        if (afterCloneCallback) afterCloneCallback(clone, count);
      }
    });
  }
}

export default Safdar;
