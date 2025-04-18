export function withLifecycle({ before, after, action }) {
    return (...args) => {
      before?.(...args);
      const result = action?.(...args);
      after?.(...args);
      return result;
    };
  }
  