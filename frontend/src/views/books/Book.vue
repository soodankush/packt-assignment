<template>
  <div>
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
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Add Book</button>
      </div>
    </form>
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
        image: 'http://placeimg.com/480/640/any',
        published_at: '',
        publisher: '',
      },
      bookImage: null,
    }
  },
  created() {
    if (this.$route.params.bookId) {
      this.bookId = this.$route.params.bookId
      this.getBookData(this.bookId)
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
      await axios
        .put(`https://packt.test/api/books/${bookId}`, { ...self.bookData })
        .then((response) => {
          console.log(response)
          if (response.status === 200) {
            self.bookData = response.data.data
          }
        })
        .catch((error) => {
          console.log(error)
        })
    },
    async postBook() {
      let self = this
      await axios
        .post(`https://packt.test/api/books`, { ...self.bookData })
        .then((response) => {
          console.log(response)
          if (response.status === 200) {
            self.bookData = response.data.data
          }
        })
        .catch((error) => {
          console.log(error)
        })
    },
    async uploadBookImage(event) {
      let self = this
      self.bookImage = event.target.files[0]
      await axios
        .post(`https://packt.test/api/books/image/upload`, self.bookImage)
        .then((response) => {
          console.log(response)
          if (response.status === 200) {
            self.bookData['image'] = response.data.data.imageName
          }
        })
        .catch((error) => {
          console.log(error)
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
        })
    },
  },
}
</script>
