// /core/Safdar.js
class Safdar {
    constructor() {
      this.registered = {};
    }
  
    // General method: attach an event to a trigger selector to perform action on target selector
    bindEvent({ triggerSelector, targetSelector, eventType, action }) {
      const triggers = document.querySelectorAll(triggerSelector);
      const target = document.querySelector(targetSelector);
  
      if (!triggers.length || !target) return;
  
      triggers.forEach(trigger => {
        trigger.addEventListener(eventType, e => {
          if (typeof action === 'function') {
            action({ trigger: trigger, target: target, event: e });
          }
        });
      });
    }
  
    // Show target element
    showElement({ triggerSelector, targetSelector, eventType }) {
      this.bindEvent({
        triggerSelector,
        targetSelector,
        eventType,
        action: ({ target }) => {
          target.style.display = 'block';
        }
      });
    }
  
    // Hide target element
    hideElement({ triggerSelector, targetSelector, eventType }) {
      this.bindEvent({
        triggerSelector,
        targetSelector,
        eventType,
        action: ({ target }) => {
          target.style.display = 'none';
        }
      });
    }
  
    // Toggle target element visibility
    toggleElement({ triggerSelector, targetSelector, eventType }) {
      this.bindEvent({
        triggerSelector,
        targetSelector,
        eventType,
        action: ({ target }) => {
          const isVisible = getComputedStyle(target).display !== 'none';
          target.style.display = isVisible ? 'none' : 'block';
        }
      });
    }

    cloneElement({ triggerSelector, targetSelector, eventType, appendToSelector }) {
      this.bindEvent({
        triggerSelector,
        targetSelector,
        eventType,
        action: ({ trigger, target }) => {
          const clone = target.cloneNode(true);
          clone.classList.remove('hidden');
    
          let appendTo = null;
    
          if (appendToSelector.startsWith('closest:')) {
            const relativeSelector = appendToSelector.replace('closest:', '');
            const closestParent = trigger.closest(relativeSelector);
    
            // If we're targeting options inside selectoption, find option-container
            appendTo = closestParent?.querySelector('.option-container');
          } else {
            appendTo = document.querySelector(appendToSelector);
          }
    
          if (appendTo) {
            appendTo.appendChild(clone);
          } else {
            console.warn(`Safdar: append target not found for selector "${appendToSelector}"`);
          }
        }
      });
    }
    
    
  
    // Register new functionality dynamically
    registerFunction(name, fn) {
      this.registered[name] = fn;
    }
  
    // Call any registered function by name
    call(name, args) {
      if (this.registered[name]) {
        this.registered[name](args);
      } else if (typeof this[name] === 'function') {
        this[name](args);
      } else {
        console.warn(`Safdar: function "${name}" not found.`);
      }
    }

    // Bind using event delegation (for dynamic elements)
delegateEvent({ parentSelector = 'body', triggerSelector, eventType, targetSelector, appendToSelector }) {
  const parent = document.querySelector(parentSelector);

  if (!parent) return;

  parent.addEventListener(eventType, (e) => {
    if (e.target.matches(triggerSelector)) {
      const target = document.querySelector(targetSelector); // the hidden clone source
      if (!target) return;

      const clone = target.cloneNode(true);
      clone.classList.remove('hidden');

      let appendTo = null;

      if (appendToSelector.startsWith('closest:')) {
        const relativeSelector = appendToSelector.replace('closest:', '');
        const closestParent = e.target.closest(relativeSelector);
        appendTo = closestParent?.querySelector('.option-container');
      } else {
        appendTo = document.querySelector(appendToSelector);
      }

      if (appendTo) {
        appendTo.appendChild(clone);
      } else {
        console.warn(`Safdar: append target not found for selector "${appendToSelector}"`);
      }
    }
  });
}

  }
  
  export default Safdar;
  