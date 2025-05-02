export function loadCategories(mainSelectorId, subSelectorId, jsonUrl) {
    fetch(jsonUrl)
      .then(res => res.json())
      .then(data => {
        const mainList = document.getElementById(mainSelectorId);
        const subList = document.getElementById(subSelectorId);
        mainList.innerHTML = '';
        subList.innerHTML = '';
  
        // Populate main categories
        for (const mainCat in data) {
          mainList.innerHTML += `<option value="${mainCat}">`;
        }
  
        // Update subcategories when main selected
        document.getElementById('main_category').addEventListener('input', e => {
          const selected = e.target.value;
          subList.innerHTML = '';
  
          const subs = data[selected];
          if (!subs) return;
  
          const flatten = (obj) => {
            const out = [];
            if (Array.isArray(obj)) return obj;
            for (const key in obj) {
              const val = obj[key];
              if (Array.isArray(val)) out.push(...val);
              else out.push(key, ...flatten(val));
            }
            return out;
          };
  
          flatten(subs).forEach(sub => {
            subList.innerHTML += `<option value="${sub}">`;
          });
        });
      })
      .catch(console.error);
  }
  