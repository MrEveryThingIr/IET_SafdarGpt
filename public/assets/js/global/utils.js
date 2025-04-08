// utils.js

// Example: a simple function to fetch JSON from an API
async function fetchJson(url, options = {}) {
    const response = await fetch(url, options);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return await response.json();
  }
  
  // Another example: toggling a class with fallback if classList is not fully supported
  function toggleClass(element, className) {
    if (element.classList) {
      element.classList.toggle(className);
    } else {
      // older browser fallback
      const classes = element.className.split(' ');
      const i = classes.indexOf(className);
      if (i >= 0) {
        classes.splice(i, 1);
      } else {
        classes.push(className);
      }
      element.className = classes.join(' ');
    }
  }
  