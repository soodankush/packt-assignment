<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <!-- <th scope="col">Sr. No.</th> -->
                  <th scope="col">Title</th>
                  <th scope="col">Author</th>
                  <th scope="col">ISBN</th>
                  <th scope="col">Published</th>
                  <th scope="col">Publisher</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(book, index) in booksData.data" :key="index">
                  <!-- <th scope="row">{{ index + 1 }}</th> -->
                  <td>
                    <h6>{{ book.title }}</h6>
                  </td>
                  <td>{{ book.author }}</td>
                  <td>{{ book.isbn }}</td>
                  <td>{{ book.published_at }}</td>
                  <td>{{ book.publisher }}</td>
                  <td>
                    <a class="actionLink"><font-awesome-icon icon="eye" /></a>
                    <a class="actionLink"><font-awesome-icon icon="edit" /></a>
                    <a class="actionLink"><font-awesome-icon icon="trash" /></a>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="text-center">
              <pagination
                v-model="page"
                :records="totalRecords"
                :per-page="10"
                @paginate="getBooksData"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Books',
  components: {},
  data() {
    return {
      booksData: [],
      page: 0,
      totalRecords: 0,
      perPage: 10,
    }
  },
  async mounted() {
    await this.getBooksData()
  },
  methods: {
    async getBooksData() {
      let self = this
      await axios
        .get('https://packt.test/api/books', {
          params: {
            page: this.page,
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
  },
}
</script>
<style scoped>
.actionLink {
  margin: 3px;
}
</style>
