<template>
  <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
    <a class="navbar-brand ml-2 font-weight-bold" href="/"
      ><span id="orange">Packt</span></a
    >
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarColor"
      aria-controls="navbarColor"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <div class="container">
    <div class="row mt-4">
      <!-- <div class="col-lg-1 text-center">
        <ul
          class="nav nav-tabs row text-center pro-details"
          id="myTab"
          role="tablist"
        >
          <li class="nav-item col-lg-12 mb-2">
            <img
              class="img-fluid active h-100"
              src="https://pbs.twimg.com/media/ENktSOKU0AA9Y-6.jpg"
              id="home-tab"
              data-toggle="tab"
              href="#home"
              role="tab"
              aria-controls="home"
              aria-selected="true"
            />
          </li>
          <li class="nav-item col-lg-12 mb-2">
            <img
              class="img-fluid h-100"
              id="profile-tab"
              data-toggle="tab"
              href="#profile"
              role="tab"
              aria-controls="profile"
              aria-selected="false"
              src="https://pbs.twimg.com/media/ENktSOTUEAELNMN.jpg"
            />
          </li>
          <li class="nav-item col-lg-12 mb-2">
            <div style="height: 50px">
              <img
                class="img-fluid h-100"
                src="https://pbs.twimg.com/media/ENktSONUEAAm6k1.jpg"
                id="contact-tab"
                data-toggle="tab"
                href="#contact"
                role="tab"
                aria-controls="contact"
                aria-selected="false"
              />
            </div>
          </li>
          <li class="nav-item col-lg-12 mb-2">
            <img
              class="img-fluid h-100"
              src="https://pbs.twimg.com/media/EOYIp0FUYAA0uM1?format=jpg&name=360x360"
              id="product-tab"
              data-toggle="tab"
              href="#product"
              role="tab"
              aria-controls="product"
              aria-selected="false"
            />
          </li>
          <li class="nav-item col-lg-12 mb-2">
            <img
              class="img-fluid h-100"
              src="https://pbs.twimg.com/media/EOYIp0DUUAA29Ft?format=jpg&name=small"
              id="productTwo-tab"
              data-toggle="tab"
              href="#productTwo"
              role="tab"
              aria-controls="productTwo"
              aria-selected="false"
            />
          </li>
          <li class="nav-item col-lg-12 mb-2">
            <img
              class="img-fluid h-100"
              src="https://pbs.twimg.com/media/EOYIp0JVUAANGFD?format=jpg&name=small"
              id="productThree-tab"
              data-toggle="tab"
              href="#productThree"
              role="tab"
              aria-controls="productThree"
              aria-selected="false"
            />
          </li>
        </ul>
      </div> -->
      <div class="col-lg-5 text-center border-right border-secondery">
        <div
          class="tab-content row h-100 d-flex justify-content-center align-items-center"
          id="myTabContent"
        >
          <div
            class="tab-pane fade show active col-lg-12"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab"
          >
            <img class="img-fluid" :src="bookData.image" />
          </div>
        </div>
      </div>
      <div class="col-lg-7">
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
</template>
<script>
import axios from 'axios'
export default {
  name: 'ViewProduct',
  data() {
    return {
      bookId: null,
      bookData: {},
    }
  },
  created() {
    this.bookId = this.$route.params.bookId
    if (this.bookId) {
      this.getBookData(this.bookId)
    }
  },
  methods: {
    async getBookData(bookId) {
      let self = this
      await axios
        .get(`https://packt.test/api/books/${bookId}`)
        .then((response) => {
          if (response.status === 200) {
            self.bookData = response.data.data
          } else {
            this.$router.push(`/pages/500`)
          }
        })
        .catch((error) => {
          console.log('error')
          console.log(error)
          this.$router.push(`/pages/404`)
        })
    },
  },
}
</script>
<style scoped>
.pro-details .nav-item {
  height: 50px;
}

.heading {
  margin-bottom: 5pc;
}
</style>
