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
    <div class="collapse navbar-collapse" id="navbarColor">
      <ul class="navbar-nav">
        <li class="nav-item rounded bg-light search-nav-item">
          <input
            type="text"
            id="search"
            class="bg-light"
            placeholder="Press enter to search title, authors, isbn, publication date, genre"
            v-model="searchTerm"
            @change="getBooksData"
          /><span class="fa fa-search text-muted"></span>
        </li>
        <li class="nav-item float-right">
          <!-- <a class="nav-link admin-link" href="/">Go To Admin Panel</a> -->
          <router-link class="nav-link admin-link" to="/books" exact
            >Go To Admin Panel</router-link
          >
        </li>
      </ul>
    </div>
  </nav>
  <div class="filter">
    <button
      class="btn btn-default"
      type="button"
      data-toggle="collapse"
      data-target="#mobile-filter"
      aria-expanded="true"
      aria-controls="mobile-filter"
    >
      Filters<span class="fa fa-filter pl-1"></span>
    </button>
  </div>
  <!-- <div id="mobile-filter">
    <p class="pl-sm-0 pl-2">Home | <b>All Breads</b></p>
    <div class="border-bottom pb-2 ml-2">
      <h4 id="burgundy">Filters</h4>
    </div>
    <div class="py-2 border-bottom ml-3">
      <h6 class="font-weight-bold">Categories</h6>
      <div id="orange"><span class="fa fa-minus"></span></div>
      <form>
        <div class="form-group">
          <input type="checkbox" id="artisan" />
          <label for="artisan">Fresh Artisan Breads</label>
        </div>
        <div class="form-group">
          <input type="checkbox" id="breakfast" />
          <label for="breakfast">Breakfast Breads</label>
        </div>
        <div class="form-group">
          <input type="checkbox" id="healthy" />
          <label for="healthy">Healthy Breads</label>
        </div>
      </form>
    </div>
    <div class="py-2 border-bottom ml-3">
      <h6 class="font-weight-bold">Accompainments</h6>
      <div id="orange"><span class="fa fa-minus"></span></div>
      <form>
        <div class="form-group">
          <input type="checkbox" id="tea" /> <label for="tea">Tea Cakes</label>
        </div>
        <div class="form-group">
          <input type="checkbox" id="cookies" />
          <label for="cookies">Cookies</label>
        </div>
        <div class="form-group">
          <input type="checkbox" id="pastries" />
          <label for="pastries">Pastries</label>
        </div>
        <div class="form-group">
          <input type="checkbox" id="dough" />
          <label for="dough">Cookie Dough</label>
        </div>
        <div class="form-group">
          <input type="checkbox" id="choco" />
          <label for="choco">Chocolates</label>
        </div>
      </form>
    </div>
    <div class="py-2 ml-3">
      <h6 class="font-weight-bold">Top Offers</h6>
      <div id="orange"><span class="fa fa-minus"></span></div>
      <form>
        <div class="form-group">
          <input type="checkbox" id="25off" /> <label for="25">25% off</label>
        </div>
        <div class="form-group">
          <input type="checkbox" id="5off" />
          <label for="5off" id="off">5% off on artisan breads</label>
        </div>
      </form>
    </div>
  </div> -->
  <!-- Sidebar filter section -->
  <section id="sidebar">
    <!-- <p>Home | <b>All Breads</b></p> -->
    <div class="border-bottom pb-2 ml-2">
      <h4 id="burgundy">Filters</h4>
    </div>
    <div
      v-for="(categoryData, category) in filtersData"
      :key="category"
      class="py-2 border-bottom ml-3"
    >
      <h6 class="font-weight-bold filter-heading">{{ category }}</h6>
      <div id="orange"><span class="fa fa-minus"></span></div>
      <form class="filter-space">
        <div
          v-for="(filter, filterIndex) in categoryData"
          :key="filterIndex"
          class="form-group"
        >
          <input
            type="checkbox"
            id="artisan"
            :value="filter"
            @change="updateSelectedFilters(category, filter)"
          />
          <label for="artisan">{{ filter }}</label>
        </div>
      </form>
    </div>
  </section>
  <!-- products section -->
  <section id="products">
    <div class="container">
      <div v-if="booksData.data.length > 0" class="row">
        <div
          v-for="(book, index) in booksData.data"
          :key="index"
          class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1"
        >
          <div class="card">
            <img class="card-img-top" :src="book.image" />
            <div class="card-body">
              <h5>
                <b>{{ book.title }}</b>
              </h5>
              <div class="d-flex flex-row my-2">
                <div class="ml-auto">
                  <span class="px-sm-1">Author: {{ book.author }}</span>
                </div>
              </div>
              <button
                class="btn w-100 rounded my-2"
                @click="viewBookDetails(book.id)"
              >
                View Details
              </button>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <pagination
            v-model="page"
            :records="totalRecords"
            :per-page="perPage"
            @paginate="getBooksData"
          />
        </div>
      </div>
      <div v-else class="justify-content-center row no-products">
        <h3 class="justify-content-center">No Products Found.</h3>
      </div>
    </div>
  </section>
</template>
<script>
import axios from 'axios'
export default {
  name: 'Index',
  data() {
    return {
      page: 0,
      perPage: 9,
      totalRecords: 0,
      booksData: [],
      filtersData: [],
      searchTerm: null,
      selectedFilters: {
        author: [],
        genre: [],
        publisher: [],
        published_at: [],
      },
    }
  },
  created() {
    this.getBooksData()
    this.getFiltersData()
  },
  methods: {
    async getBooksData() {
      let self = this
      await axios
        .get('https://packt.test/api/books', {
          params: {
            page: self.page,
            perPage: self.perPage,
            search: self.searchTerm,
            filters: self.selectedFilters,
          },
        })
        .then((booksResponse) => {
          if (booksResponse.status === 200) {
            self.booksData = booksResponse.data.data
            self.totalRecords = parseInt(self.booksData.total)
            self.page = parseInt(self.booksData.current_page)
          }
        })
        .catch((error) => {
          console.log(`Error Response`)
          console.log(error)
        })
    },
    async getFiltersData() {
      let self = this
      await axios
        .get('https://packt.test/api/books/filters')
        .then((response) => {
          if (response.status === 200) {
            self.filtersData = response.data.data
          }
        })
        .catch((error) => {
          console.log(error)
        })
    },
    async viewBookDetails(bookId) {
      this.$router.push(`/view/${bookId}`)
    },
    updateSelectedFilters(filterType, filterData) {
      if (this.selectedFilters[filterType].includes(filterData)) {
        const index = this.selectedFilters[filterType].indexOf(filterData)
        this.selectedFilters[filterType].splice(index, 1)
      } else {
        this.selectedFilters[filterType].push(filterData)
      }
      this.getBooksData()
    },
    goToDashboard() {
      console.log('hello')
    },
  },
}
</script>
<style scoped>
* {
  box-sizing: border-box;
}

#search {
  outline: none;
  border: none;
  display: inline-block;
}

#burgundy {
  color: rgb(153, 40, 59);
}

#orange,
select,
.btn {
  color: orange;
}

.fa-search {
  font-size: 20px;
  padding: 10px;
  margin-bottom: 3px;
  padding-right: 20px;
}

.search-nav-item {
  height: 40px;
}

nav {
  padding: 0px 100px;
}

.fa-user-o,
.fa-shopping-cart {
  font-size: 20px;
  padding: 4px;
}

.form-group {
  margin-bottom: 5px;
}

label {
  padding-left: 10px;
}

.form-group:last-child {
  margin-bottom: 0;
}

h5 {
  height: 50px !important;
}

h6 {
  margin-bottom: 10px;
}

#sort {
  outline: none;
  border: none;
}

.btn {
  border: 1px solid orange;
  border-radius: 10px;
  background-color: #fff;
}

.btn:hover {
  color: #fff;
  background-color: orange;
}

.card-body {
  padding: 8px;
}

.sign {
  width: 25px;
  height: 25px;
}

.discount {
  border: 1px solid orange;
  border-radius: 5px;
  width: 65px;
  position: absolute;
  top: 2%;
}

@media (min-width: 1200px) {
  #search {
    width: 300px;
    padding: 5px;
    padding-left: 20px;
  }

  .search-nav-item {
    margin-left: 400px;
    width: 350px;
  }

  .fa-user-o {
    margin-left: 300px;
  }

  .text {
    display: none;
  }

  .fa-user-o,
  .fa-shopping-cart {
    font-size: 20px;
    padding-left: 20px;
  }

  #sidebar {
    width: 30%;
    padding: 20px;
    float: left;
  }

  #products {
    width: 70%;
    padding: 10px;
    margin: 0;
    float: right;
  }

  .card {
    width: 300px;
    /* height: 330px; */
    border: none;
  }

  .card-img-top {
    width: 295px;
    height: 200px;
    border-radius: 10px;
  }

  del {
    padding-right: 2px;
  }

  .filter,
  #mobile-filter {
    display: none;
  }
}

@media (min-width: 992px) and (max-width: 1199px) {
  #search {
    width: 300px;
    padding: 5px;
    padding-left: 20px;
  }

  .search-nav-item {
    margin-left: 200px;
    width: 350px;
  }

  .fa-user-o {
    margin-left: 160px;
  }

  .text {
    display: none;
  }

  #sidebar {
    width: 30%;
    padding: 20px;
    float: left;
  }

  #products {
    width: 70%;
    padding: 10px;
    margin: 0;
    float: right;
  }

  .card {
    width: 200px;
    /* height: 330px; */
    border: none;
  }

  .card-img-top {
    width: 200px;
    height: 200px;
    border-radius: 10px;
  }

  .fa-plus,
  .fa-minus {
    font-size: 12px;
  }

  .sign {
    height: 25px;
  }

  .price {
    width: 99px;
  }

  .filter,
  #mobile-filter {
    display: none;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  #search {
    width: 300px;
    padding: 5px;
    padding-left: 20px;
  }

  .search-nav-item {
    margin-left: 60px;
    width: 350px;
  }

  .fa-user-o {
    margin-left: 80px;
  }

  .text {
    display: none;
  }

  #sidebar {
    width: 35%;
    padding: 20px;
    float: left;
  }

  #products {
    width: 65%;
    padding: 10px;
    margin: 0;
    float: right;
  }

  .card {
    border: none;
  }

  .filter,
  #mobile-filter {
    display: none;
  }
}

@media (min-width: 576px) and (max-width: 767px) {
  .text {
    display: none;
  }

  .search-nav-item {
    margin-left: 35px;
    width: 270px;
  }

  #search {
    width: 240px;
    padding: 5px;
    padding-left: 20px;
  }

  .fa-search {
    padding: 3px;
    font-size: 18px;
  }

  #sidebar {
    width: 40%;
    padding: 20px;
    float: left;
  }

  #products {
    width: 60%;
    padding: 10px;
    margin: 0;
    float: right;
  }

  .card {
    border: none;
  }

  #off {
    padding-left: 2px;
  }

  #sorting span,
  #res {
    font-size: 14px;
  }

  .filter,
  #mobile-filter {
    display: none;
  }
}

@media (max-width: 575px) {
  .search-nav-item {
    margin: 0;
    width: 100%;
    margin-top: 10px;
  }

  #search {
    width: 80%;
    padding-left: 10px;
    margin-top: 10px;
    padding-right: 10px;
  }

  .fa-search {
    padding: 10px;
    font-size: 18px;
  }

  #sidebar {
    display: none;
  }

  .filter {
    margin-left: 70%;
    margin-top: 2%;
  }

  #sorting,
  #res {
    font-size: 12px;
    margin-top: 2%;
  }
}

.filter-space {
  height: 100px;
  overflow: scroll;
  margin-bottom: 10px;
}

.admin-link {
  text-decoration: underline;
}
</style>
