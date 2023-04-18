<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <div v-if="bookData.image" class="img-preview">
          <img :src="bookData.image" />
        </div>
        <div v-else>
          <h3 class="sub-heading">No Preview Available</h3>
        </div>
      </div>
      <div class="col-md-8">
        <form class="row g-3" @submit.prevent="postOrUpdateBookData">
          <div class="col-md-6">
            <label for="title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="title"
              placeholder="Enter Title here"
              v-model="bookData.title"
            />
            <div v-if="errors.title" color="danger">
              <p class="error">{{ errors.title[0] }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <label for="author" class="form-label">Author</label>
            <input
              type="text"
              class="form-control"
              id="author"
              placeholder="Author Name"
              v-model="bookData.author"
            />
            <div v-if="errors.author" color="danger">
              <p class="error">{{ errors.author[0] }}</p>
            </div>
          </div>
          <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <input
              type="text"
              class="form-control"
              id="description"
              placeholder="Enter Book Description"
              v-model="bookData.description"
            />
            <div v-if="errors.description" color="danger">
              <p class="error">{{ errors.description[0] }}</p>
            </div>
          </div>
          <div class="col-md-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input
              type="text"
              class="form-control"
              id="isbn"
              placeholder="Mention ISBN"
              v-model="bookData.isbn"
            />
            <div v-if="errors.isbn" color="danger">
              <p class="error">{{ errors.isbn[0] }}</p>
            </div>
          </div>
          <div class="col-md-3">
            <label for="genre" class="form-label">Genre</label>
            <input
              type="text"
              class="form-control"
              id="genre"
              placeholder="Genre"
              v-model="bookData.genre"
            />
            <div v-if="errors.genre" color="danger">
              <p class="error">{{ errors.genre[0] }}</p>
            </div>
          </div>
          <div class="col-md-3">
            <label for="publishedAt" class="form-label">Published At</label>
            <input
              type="text"
              class="form-control"
              id="publishedAt"
              placeholder="Enter published at"
              v-model="bookData.published_at"
            />
            <div v-if="errors.published_at" color="danger">
              <p class="error">{{ errors.published_at[0] }}</p>
            </div>
          </div>
          <div class="col-md-3">
            <label for="publisher" class="form-label">Publisher:</label>
            <input
              type="text"
              class="form-control"
              id="publisher"
              placeholder="Publisher"
              v-model="bookData.publisher"
            />
            <div v-if="errors.publisher" color="danger">
              <p class="error">{{ errors.publisher[0] }}</p>
            </div>
          </div>
          <div class="col-md-3">
            <label for="image" class="form-label">Image</label>
            <input
              type="file"
              class="form-control"
              id="file"
              placeholder="image"
              @change="uploadBookImage"
            />
            <div v-if="errors.image" color="danger">
              <p class="error">{{ errors.image[0] }}</p>
            </div>
          </div>
          <div class="justify-content-center col-12">
            <button type="submit" class="btn btn-primary">
              {{ btnMessage }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
<script>
import axios from 'axios'
export default {
  name: 'Book',
  data() {
    return {
      bookId: null,
      bookData: {
        title: '',
        author: '',
        genre: '',
        description: '',
        isbn: '',
        image: '',
        published_at: '',
        publisher: '',
      },
      bookImage: null,
      btnMessage: 'Add Book',
      errors: {},
    }
  },
  created() {
    if (this.$route.params.bookId) {
      this.bookId = this.$route.params.bookId
      this.getBookData(this.bookId)
      this.btnMessage = 'Update Book'
    }
  },
  unmounted() {
    this.bookId = null
    this.bookImage = null
  },
  methods: {
    postOrUpdateBookData() {
      this.bookId !== null ? this.updateBook(this.bookId) : this.postBook()
    },
    async updateBook(bookId) {
      let self = this
      self.errors = {}
      await axios
        .put(`https://packt.test/api/books/${bookId}`, { ...self.bookData })
        .then((response) => {
          console.log(response)
          if (response.status === 201) {
            self.bookData = response.data.data
            this.$toast.show('Book updated successfully', {
              type: 'success',
              position: 'bottom',
            })
          }
        })
        .catch((error) => {
          console.log(error)
          self.errors = error.response.data.errors
          this.$toast.show('Error while updating a book', {
            type: 'error',
            position: 'bottom',
          })
        })
    },
    async postBook() {
      let self = this
      self.errors = {}
      await axios
        .post(`https://packt.test/api/books`, { ...self.bookData })
        .then((response) => {
          console.log(response)
          console.log(response)
          if (response.status === 201) {
            self.bookData = response.data.data
            self.bookData = {
              title: '',
              author: '',
              genre: '',
              description: '',
              isbn: '',
              image: '',
              published_at: '',
              publisher: '',
            }
            this.$toast.show('Book added successfully', {
              type: 'success',
              position: 'bottom',
            })
          }
        })
        .catch((error) => {
          console.log(`error`)
          console.log(error)
          self.errors = error.response.data.errors
          this.$toast.show('Error while creating a book', {
            type: 'error',
            position: 'bottom',
          })
        })
    },
    async uploadBookImage(event) {
      let self = this
      self.bookImage = event.target.files[0]
      const config = {
        headers: {
          'content-type': 'multipart/form-data',
        },
      }
      await axios
        .post(
          `https://packt.test/api/books/upload`,
          { image: self.bookImage },
          config,
        )
        .then((response) => {
          console.log(response)
          if (response.status === 201) {
            self.bookData['image'] = response.data.filePath
            this.$toast.show('Image uploaded successfully', {
              type: 'success',
              position: 'bottom',
            })
          }
        })
        .catch((error) => {
          console.log(error)
          this.$toast.show('Error uploading image', {
            type: 'error',
            position: 'bottom',
          })
        })
    },
    async getBookData(bookId) {
      let self = this
      await axios
        .get(`https://packt.test/api/books/${bookId}`)
        .then((response) => {
          console.log(response)
          if (response.status === 200) {
            self.bookData = response.data.data
          }
        })
        .catch((error) => {
          console.log(error)
          this.$toast.show('Error fetching book details', {
            type: 'error',
            position: 'bottom',
          })
        })
    },
  },
}
</script>
<style scoped>
p.error {
  color: red;
  font-size: 0.7em;
  margin-left: 5px;
}

.sub-heading {
  color: grey;
}

.img-preview > img {
  height: auto;
  width: 300px;
}
</style>
