class Safdar {
  constructor() {
    this.registry = {};         // custom/utility functions
    this.indexMap = new Map();  // for managing dynamic clone indices
  }

  call(name, args = {}) {
    const fn = this.registry[name] || this[name];
    if (typeof fn === 'function') {
      return fn.call(this, args);
    } else {
      console.warn(`Safdar: Function "${name}" not found.`);
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
      if (e.target.matches(triggerSelector)) {
        const target = document.querySelector(targetSelector);
        if (!target) return;

        const clone = target.cloneNode(true);
        clone.classList.remove('hidden');

        const appendTo = appendToSelector.startsWith('closest:')
          ? e.target.closest(appendToSelector.replace('closest:', ''))?.querySelector('.option-container')
          : document.querySelector(appendToSelector);

        if (appendTo) {
          appendTo.appendChild(clone);

          const fieldsets = document.querySelectorAll('.selectoption');
          const currentIndex = [...fieldsets].indexOf(e.target.closest('.selectoption'));

          clone.querySelectorAll('[name]').forEach(input => {
            input.name = input.name.replace(/\[\]/, `[${currentIndex}][]`);
          });
        } else {
          console.warn(`Safdar: append target not found for selector "${appendToSelector}"`);
        }
      }
    });
  }

  cloneElement({ triggerSelector, targetSelector, appendToSelector, eventType = 'click', contextKey }) {
    this.bindEvent({
      triggerSelector,
      targetSelector,
      eventType,
      action: ({ trigger, target }) => {
        if (!target) return;
        const clone = target.cloneNode(true);
        clone.classList.remove('hidden');

        let appendTo = appendToSelector.startsWith('closest:')
          ? trigger.closest(appendToSelector.replace('closest:', ''))?.querySelector('.option-container')
          : document.querySelector(appendToSelector);

        if (appendTo) {
          appendTo.appendChild(clone);

          if (contextKey) {
            const count = (this.indexMap.get(contextKey) ?? 0);
            this.indexMap.set(contextKey, count + 1);

            clone.querySelectorAll('[name]').forEach(input => {
              input.name = input.name.replace(/\[\]/, `[${count}][]`);
            });

            clone.dataset.contextIndex = count;
          }
        } else {
          console.warn(`Safdar: appendTo target not found for selector "${appendToSelector}"`);
        }
      }
    });
  }
}

export default Safdar;
