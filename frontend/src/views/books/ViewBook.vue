<template>
  <div>
    <div class="row">
      <div class="col-md-5">
        <div class="justify-content-center">
          <img :src="bookData.image" class="product-image" />
        </div>
      </div>
      <div class="col-md-7">
        <div class="justify-content-center">
          <div class="heading">
            <h1>{{ bookData.title }}</h1>
          </div>
          <h3>Author: {{ bookData.author }}</h3>
          <hr />
          <p>
            Description: <b>{{ bookData.description }}</b>
          </p>
          <hr />
          <p>
            ISBN: <b>{{ bookData.isbn }}</b>
          </p>
          <hr />
          <p>
            Genre: <b>{{ bookData.genre }}</b>
          </p>
          <hr />
          <p>
            Published Date: <b>{{ bookData.published_at }}</b>
          </p>
          <hr />
          <p>
            Publisher: <b>{{ bookData.publisher }}</b>
          </p>
        </div>
      </div>
    </div>
    <!-- <form class="row g-3">
      <div class="col-md-6">
        <label for="title" class="form-label">Title</label>
        <input
          type="text"
          class="form-control"
          id="title"
          v-model="bookData.title"
          disabled="true"
        />
      </div>
      <div class="col-md-6">
        <label for="author" class="form-label">Author</label>
        <input
          type="text"
          class="form-control"
          id="author"
          v-model="bookData.author"
          disabled="true"
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
          disabled="true"
        />
      </div>
      <div class="col-md-3">
        <label for="isbn" class="form-label">ISBN</label>
        <input
          type="text"
          class="form-control"
          id="isbn"
          v-model="bookData.isbn"
          disabled="true"
        />
      </div>
      <div class="col-md-3">
        <label for="genre" class="form-label">Genre</label>
        <input
          type="text"
          class="form-control"
          id="genre"
          v-model="bookData.genre"
          disabled="true"
        />
      </div>
      <div class="col-md-3">
        <label for="publishedAt" class="form-label">Published At</label>
        <input
          type="text"
          class="form-control"
          id="publishedAt"
          v-model="bookData.published_at"
          disabled="true"
        />
      </div>
      <div class="col-md-3">
        <label for="publisher" class="form-label">Publisher:</label>
        <input
          type="text"
          class="form-control"
          id="publisher"
          v-model="bookData.publisher"
          disabled="true"
        />
      </div>
      <div class="col-md-3">
        <label for="image" class="form-label">Image:</label>
        <img :src="bookData.image" />
      </div>
    </form> -->
  </div>
</template>
<style scoped></style>
<script>
import axios from 'axios'
export default {
  name: 'ViewBook',
  data() {
    return {
      bookId: null,
      bookData: {},
    }
  },
  mounted() {
    this.bookId = this.$route.params.bookId
    this.getBookData(this.bookId)
  },
  methods: {
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
<style scoped>
.heading {
  margin-bottom: 5pc;
}

.product-image {
  width: 400px;
  height: auto;
}
</style>
