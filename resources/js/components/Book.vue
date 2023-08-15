<template>

    <BookValidation :book="newBook" @validation-completed="handleValidation" />
    <Toast :message="toastMessage" :type="toastType" />
    <div>
        <!-- Add Book Form with Validation -->
        <div class="add-book">
            <h2>Add a New Book</h2>

            <input v-model="newBook.title" placeholder="Title">
            <div v-if="errors.title" class="error">{{ errors.title }}</div>

            <input v-model="newBook.author" placeholder="Author">
            <div v-if="errors.author" class="error">{{ errors.author }}</div>

            <input type="date" v-model="newBook.publication_date" placeholder="Publication Date">
            <div v-if="errors.publication_date" class="error">{{ errors.publication_date }}</div>

            <textarea v-model="newBook.description" placeholder="Description"></textarea>
            <div v-if="errors.description" class="error">{{ errors.description }}</div>

            <button @click="createBook">Add Book</button>
        </div>

        <!-- List of Books in a Table -->
        <table class="books-table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Publication Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="book in books" :key="book.id">
                <td>{{ book.title }}</td>
                <td>{{ book.author }}</td>
                <td>{{ book.publication_date }}</td>
                <td>{{ book.description }}</td>
                <td>
                    <button @click="showEditForm(book)">Edit</button>
                    <button @click="deleteBook(book)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Edit Book Modal -->
        <div v-if="editMode" class="modal">
            <div class="modal-content">
                <h2>Edit Book</h2>

                <input v-model="editingBook.title" placeholder="Title">
                <input v-model="editingBook.author" placeholder="Author">
                <input type="date" v-model="editingBook.publication_date" placeholder="Publication Date">
                <textarea v-model="editingBook.description" placeholder="Description"></textarea>

                <button @click="updateBook">Update</button>
                <button @click="cancelEdit">Cancel</button>
            </div>
        </div>
    </div>

    <div class="pagination">
        <button @click="prevPage" :disabled="pagination.current_page <= 1">Previous</button>
        <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
        <button @click="nextPage" :disabled="pagination.current_page >= pagination.last_page">Next</button>
    </div>

    <button @click="logout">Logout</button>

</template>

<script>
import { ref, reactive } from 'vue';
import axios from 'axios';
import Toast from './Toast.vue';
import BookValidation from './BookValidation.vue';

export default {
    name: 'Book',
    components: {
        Toast ,
        BookValidation
    },

    methods: {
        async logout() {
            try {
                // Remove the token from localStorage
                localStorage.removeItem('authToken');
                location.reload();
            } catch (error) {
                console.error("Failed to log out:", error);
            }
        }
    },


    setup() {

        const handleValidation = (validationErrors) => {
            Object.assign(errors, validationErrors);
            canSubmit.value = Object.values(validationErrors).every(val => !val);
        };

        const toastMessage = ref('');
        const toastType = ref('success');
        const showToast = (message, type = 'success') => {
            toastMessage.value = ''; // Reset message first
            setTimeout(() => { // Introduce a slight delay
                toastMessage.value = message;
                toastType.value = type;
            }, 0);
        };

        const books = ref([]);
        const canSubmit = ref(false);

        const newBook = reactive({
            title: '',
            author: '',
            publication_date: '',
            description: ''
        });
        const errors = reactive({
            global: '',
            title: '',
            author: '',
            publication_date: '',
            description: ''
        });

        const editMode = ref(false);
        const editingBook = reactive({
            id: null,
            title: '',
            author: '',
            publication_date: '',
            description: ''
        });

        // Fetch books from the server when component is mounted
        const fetchBooks = async () => {
            try {
                const response = await axios.get(`/api/books?page=${pagination.current_page}`);
                books.value = response.data.data;  // .data because of Laravel's pagination structure
                pagination.last_page = response.data.last_page;
            } catch (error) {
                console.error("There was an error fetching books:", error);
            }
        };

        const pagination = reactive({
            current_page: 1,
            last_page: 1,
        });

        const nextPage = () => {
            if (pagination.current_page < pagination.last_page) {
                pagination.current_page++;
                fetchBooks();
            }
        };

        const prevPage = () => {
            if (pagination.current_page > 1) {
                pagination.current_page--;
                fetchBooks();
            }
        };

        // Call fetchBooks when the component is mounted
        fetchBooks();

        const createBook = async () => {

            if (!canSubmit.value) {
                return;
            }

            try {
                await axios.post('/api/books', newBook);
                showToast('Book added successfully!');

                clearNewBook();

                const response = await axios.get('/api/books');
                pagination.last_page = response.data.last_page;
                pagination.current_page = pagination.last_page;
                fetchBooks();
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    showToast('Unsuccessfully!', 'error');
                    Object.assign(errors, error.response.data.errors);
                }
            }
        };

        const showEditForm = (book) => {
            editMode.value = true;
            Object.assign(editingBook, book);
        };

        const updateBook = async () => {

            try {
                const response = await axios.put(`/api/books/${editingBook.id}`, editingBook);
                const index = books.value.findIndex(b => b.id === editingBook.id);
                if (index !== -1) {
                    books.value.splice(index, 1, response.data);
                }
                editMode.value = false;
                showToast('Book Edited successfully!');
            } catch (error) {
                showToast('Unsuccessfully!','error');
                console.error("Error updating book:", 'error');
            }
        };

        const deleteBook = async (book) => {
            try {
                await axios.delete(`/api/books/${book.id}`);
                showToast('Book Deleted successfully!');
                const index = books.value.findIndex(b => b.id === book.id);
                if (index !== -1) {
                    books.value.splice(index, 1);
                }

                // Check if the current page is now empty after deletion.
                if (books.value.length === 0 && pagination.current_page > 1) {
                    pagination.current_page--;
                    fetchBooks();
                } else if (books.value.length > 0) {
                    fetchBooks();
                }
            } catch (error) {
                showToast('Unsuccessfully!','error');
                console.error("Error deleting book:", error);
            }
        };

        const cancelEdit = () => {
            editMode.value = false;
        };

        const clearNewBook = () => {
            newBook.title = '';
            newBook.author = '';
            newBook.publication_date = '';
            newBook.description = '';
        };

        return {
            books, newBook, errors, createBook, showEditForm, deleteBook,
            editMode, editingBook, cancelEdit, updateBook, pagination, nextPage, prevPage,
            showToast, toastMessage, toastType, handleValidation
        }
    }
}
</script>

<style scoped>
.error {
    color: red;
    font-size: 0.9em;
    margin-bottom: 10px;
}

.books-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.books-table th, .books-table td {
    border: 1px solid #ccc;
    padding: 8px 12px;
}

.books-table th {
    background-color: #f5f5f5;
}

button {
    padding: 5px 15px;
    margin: 0 5px;
    cursor: pointer;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    width: 80%;
    max-width: 500px;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination button {
    padding: 5px 15px;
    margin: 0 10px;
    cursor: pointer;
}

.pagination span {
    margin: 0 10px;
}

body {
    font-family: 'Arial', sans-serif;
    margin: 20px;
    background-color: #f4f4f4;
}

input, textarea, button {
    font-size: 16px;
}

.add-book {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button:hover {
    opacity: 0.8;
}

.books-table tr:hover {
    background-color: #f9f9f9;
}

@media (max-width: 768px) {
    .modal-content {
        width: 95%;
    }

    input, textarea {
        margin: 5px 0;
    }
}

</style>
