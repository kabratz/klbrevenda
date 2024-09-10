export default {
    beforeMount(el) {
        const formatPhone = (value) => {
            let cleanValue = value.replace(/\D/g, '');
            if (cleanValue.startsWith('55')) {
                cleanValue = cleanValue.slice(2); // Remove the country code if it is there
            }
            if (cleanValue.length > 11) cleanValue = cleanValue.slice(0, 11);

            if (cleanValue.length >= 8) {
                return `+55 (${cleanValue.slice(0, 2)}) ${cleanValue.slice(2, 7)}-${cleanValue.slice(7)}`;
            } else if (cleanValue.length >= 3) {
                return `+55 (${cleanValue.slice(0, 2)}) ${cleanValue.slice(2)}`;
            } else {
                return `+55 (${cleanValue}`;
            }
        };

        const handleInput = (event) => {
            const input = event.target;
            const originalValue = input.value;
            const formattedValue = formatPhone(originalValue);

            if (input.value !== formattedValue) {
                input.value = formattedValue;
                input.dispatchEvent(new Event('input', { bubbles: true }));
            }
        };

        el.addEventListener('input', handleInput);

        el._removeListener = () => {
            el.removeEventListener('input', handleInput);
        };
    },
    unmounted(el) {
        if (el._removeListener) {
            el._removeListener();
        }
    }
};
