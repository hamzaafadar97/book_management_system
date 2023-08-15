<template>
    <div>
        <div v-if="errors.global" class="error">{{ errors.global }}</div>
        <div v-if="errors.title" class="error">{{ errors.title }}</div>
        <div v-if="errors.author" class="error">{{ errors.author }}</div>
        <div v-if="errors.publication_date" class="error">{{ errors.publication_date }}</div>
        <div v-if="errors.description" class="error">{{ errors.description }}</div>
    </div>
</template>

<script>
export default {
    props: ['book'],
    data() {
        return {
            errors: {
                global: '',
                title: '',
                author: '',
                publication_date: '',
                description: ''
            }
        }
    },
    watch: {
        book: {
            deep: true,
            handler: 'validate'
        }
    },
    methods: {
        validate() {
            this.clearErrors();

            if (!this.book.title.trim()) {
                this.errors.title = 'Title is required';
            } else if (this.book.title.length > 255) {
                this.errors.title = 'Title is too long';
            }

            if (!this.book.author.trim()) {
                this.errors.author = 'Author is required';
            } else if (this.book.author.length > 255) {
                this.errors.author = 'Author is too long';
            }

            if (!this.book.publication_date) {
                this.errors.publication_date = 'Publication date is required';
            }

            if (!this.book.description.trim()) {
                this.errors.description = 'Description is required';
            } else if (this.book.description.length > 1000) {
                this.errors.description = 'Description is too long (max 1000 characters)';
            }

            this.$emit('validation-completed', this.errors);
        },
        clearErrors() {
            this.errors = {
                global: '',
                title: '',
                author: '',
                publication_date: '',
                description: ''
            }
        }
    },
    created() {
        this.validate();
    }
}
</script>
