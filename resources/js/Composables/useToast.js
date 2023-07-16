import {ref} from "vue";
import { v4 as uuidv4 } from 'uuid';

const toasts = ref([])

export function useToast() {
    function addToast(message, type = 'info') {
        const toast = {
            id: uuidv4(),
            type,
            message
        }

        toasts.value.push(toast)

        setTimeout(() => {
            deleteToast(toast.id)
        }, 3500);
    }

    const deleteToast = (id) => {
        toasts.value = toasts.value.filter(toast => toast.id != id)
    }

    return {
        toasts,
        addToast,
        deleteToast,
    }
}