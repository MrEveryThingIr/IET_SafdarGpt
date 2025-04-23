// File: /assets/js/safdar_lib/plugins/auto/conditionalAction.js

export function conditionalAction({ rules = [] } = {}) {
    rules.forEach(rule => {
      const {
        watchSelector,
        eventType = 'change',
        conditions = [],
        actions = [],
        fallbackActions = []
      } = rule;
  
      const elements = document.querySelectorAll(watchSelector);
      if (!elements.length) return;
  
      elements.forEach(el => {
        el.addEventListener(eventType, e => {
          const triggerValue = e.target.value;
  
          const passed = conditions.every(cond => {
            switch (cond.operator) {
              case 'equals':     return triggerValue === cond.value;
              case 'not_equals': return triggerValue !== cond.value;
              case 'includes':   return triggerValue.includes(cond.value);
              case 'regex':      return new RegExp(cond.value).test(triggerValue);
              case 'is_checked': return e.target.checked === true;
              case 'not_empty':  return triggerValue.trim() !== '';
              default: return false;
            }
          });
     
          const execute = (acts) => {
            acts.forEach(action => {
              const root = e.target.closest('.input');
const targets = root ? root.querySelectorAll(action.targetSelector) : [];
              if (!targets.length) return;
  
              targets.forEach(t => {
                switch (action.type) {
                  case 'show':
                    t.classList.remove('hidden');
                    break;
                  case 'hide':
                    t.classList.add('hidden');
                    break;
                  case 'toggle':
                    t.classList.toggle(action.className ?? 'hidden');
                    break;
                  case 'add_class':
                    t.classList.add(action.className);
                    break;
                  case 'remove_class':
                    t.classList.remove(action.className);
                    break;
                  case 'enable':
                    t.disabled = false;
                    break;
                  case 'disable':
                    t.disabled = true;
                    break;
                  case 'set_value':
                    t.value = action.value;
                    break;
                  case 'focus':
                    t.focus();
                    break;
                }
              });
            });
          };
  
          if (passed) {
            execute(actions);
          } else {
            execute(fallbackActions);
          }
        });
      });
    });
  }
  
//   Operator	Purpose
// equals	Matches exact value
// not_equals	Not equal to value
// includes	Value includes string
// regex	Regex pattern matches
// is_checked	For checkbox/radio inputs
// not_empty	Value is not blank
// ✅ Supported action.type values

// Action Type	Description
// show	Remove hidden class
// hide	Add hidden class
// toggle	Toggle a class (defaults to hidden)
// add_class	Add a custom class
// remove_class	Remove a custom class
// enable	Enable a form input
// disable	Disable a form input
// set_value	Set value of a field
// focus	Move focus to an input