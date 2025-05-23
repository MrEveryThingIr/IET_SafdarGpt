  function clock() {
    return {
      year: '',
      month: '',
      day: '',
      hour: '',
      minute: '',
      second: '',
      animations: {
        'flip-down': 'transform rotate-x-12 scale-110 text-blue-400',
        'slide-up': 'transform -translate-y-1 scale-95 text-pink-400',
        'scale-in': 'transform scale-125 text-yellow-400',
        'blur-in': 'blur-sm hover:blur-0 text-teal-300',
        'fade-in': 'opacity-50 hover:opacity-100 text-indigo-300',
        'rotate-y': 'transform rotate-y-180 scale-110 text-rose-400',
        'rotate-x': 'transform rotate-x-180 text-cyan-300',
        'translate-z': 'transform scale-150 text-green-300',
        'zoom-out': 'scale-75 hover:scale-100 text-orange-400',
        'pulse': 'animate-pulse text-purple-400',
        'bounce': 'animate-bounce text-lime-400',
        'wiggle': 'hover:rotate-3 text-fuchsia-400',
        'shrink': 'hover:scale-90 text-emerald-400',
        'grow': 'hover:scale-105 text-violet-400',
        'tilt': 'hover:-rotate-6 text-red-400',
        'shake': 'hover:translate-x-1 text-blue-200',
        'drop': 'hover:translate-y-2 text-sky-400',
        'flip-left': 'hover:rotate-y-12 text-pink-300',
        'zoom-in': 'hover:scale-110 text-yellow-300',
        'wiggle-x': 'hover:-translate-x-1 text-green-200',
        'fade-out': 'hover:opacity-75 text-zinc-200',
        'lightup': 'hover:text-white hover:scale-105',
        'blur-out': 'hover:blur-sm text-gray-300',
        'scale-bounce': 'hover:scale-110 hover:animate-bounce text-teal-200',
      },
      start() {
        this.update();
        setInterval(() => this.update(), 1000);
      },
      update() {
        const now = new Date();
        this.year = now.getFullYear();
        this.month = String(now.getMonth() + 1).padStart(2, '0');
        this.day = String(now.getDate()).padStart(2, '0');
        this.hour = String(now.getHours()).padStart(2, '0');
        this.minute = String(now.getMinutes()).padStart(2, '0');
        this.second = String(now.getSeconds()).padStart(2, '0');
      }
    };
  }

  // Safe Template Component Registration
  function registerTemplate(name, templateId) {
    document.addEventListener("DOMContentLoaded", () => {
      const tmpl = document.getElementById(templateId);
      if (!tmpl) {
        console.error(`Template with id '${templateId}' not found.`);
        return;
      }

      if (!customElements.get(name)) {
        customElements.define(name, class extends HTMLElement {
          constructor() {
            super();
            const clone = tmpl.content.cloneNode(true);
            const text = this.getAttribute('x-text');
            const label = this.getAttribute('label');
            const anim = this.getAttribute('anim');

            const textEl = clone.querySelector('[x-text="text"]');
            const labelEl = clone.querySelector('[x-text="label"]');
            const animatedEl = clone.querySelector('div');

            if (textEl) textEl.setAttribute('x-text', text);
            if (labelEl) labelEl.setAttribute('x-text', `"${label}"`);
            if (animatedEl) animatedEl.setAttribute('x-bind:class', `transition-all duration-500 ease-in-out ${clock().animations[anim]}`);

            this.appendChild(clone);
          }
        });
      }
    });
  }

  // Register both templates
  registerTemplate("DatePart", "DatePart");
  registerTemplate("TimePart", "TimePart");