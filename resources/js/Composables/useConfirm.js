import {ref} from "vue";

const visible = ref(false)
const title = ref('')
const message = ref('')

const promise = ref()

export function useConfirm() {
    const show = (_title, _message) => {
        title.value = _title
        message.value = _message
        visible.value = true

        return new Promise((resolve, reject) => {
            promise.value = resolve
        })
    }

    const hide = () => {
        visible.value = false

        setTimeout(() => {
            title.value = message.value = ''
        }, 500)
    }

    const confirm = () => {
        promise.value(true)
        hide()
    }

    const cancel = () => {
        promise.value(false)
        hide()
    }

    return {
        visible,
        title,
        message,
        show,
        hide,
        confirm,
        cancel,
    }
}