<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="6">
          <span class="clearfix">
            <h1 class="float-start display-3 me-4">500</h1>
            <h4 class="pt-3">Houston, we have a problem!</h4>
            <p class="text-medium-emphasis float-start">
              The page you are looking for is temporarily unavailable.
            </p>
          </span>
        </CCol>
      </CRow>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="go-to-home-btn">
            <button class="btn btn-primary" @click="goToHome">
              Go to Home
            </button>
          </div>
        </div>
      </div>
    </CContainer>
  </div>
</template>

<script>
export default {
  name: 'Page500',
  methods: {
    goToHome() {
      this.$router.push('/')
    },
  },
}
</script>
