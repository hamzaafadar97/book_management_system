<template>
    <div v-if="visible" :class="['toast', type]" @click="hide">
        {{ message }}
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'success'
        },
        duration: {
            type: Number,
            default: 3000
        }
    },
    data() {
        return {
            visible: false
        };
    },
    watch: {
        message(newVal) {
            if (newVal) {
                this.show();
            }
        }
    },
    methods: {
        show() {
            this.visible = true;
            setTimeout(this.hide, this.duration);
        },
        hide() {
            this.visible = false;
        }
    }
}
</script>

<style>
.toast {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 10px 20px;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}

.toast.success {
    background-color: green;
}

.toast.error {
    background-color: orange;
}
</style>
