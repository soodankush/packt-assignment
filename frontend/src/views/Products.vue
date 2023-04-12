<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
          <strong>Products</strong>
        </CCardHeader>
        <CCardBody>
          <CRow :xs="{ cols: 1, gutter: 4 }" :md="{ cols: 3 }">
            <CCol xs>
              <CCard>
                <CCardImage orientation="top" :src="VueImg" />
                <CCardBody>
                  <CCardTitle>Card title</CCardTitle>
                  <CCardText>
                    This is a wider card with supporting text below as a natural
                    lead-in to additional content. This content is a little bit
                    longer.
                  </CCardText>
                </CCardBody>
                <CCardFooter>
                  <small class="text-medium-emphasis">Author: </small>
                </CCardFooter>
              </CCard>
            </CCol>
            <CCol xs>
              <CCard>
                <CCardImage orientation="top" :src="VueImg" />
                <CCardBody>
                  <CCardTitle>Card title</CCardTitle>
                  <CCardText>
                    This is a wider card with supporting text below as a natural
                    lead-in to additional content. This content is a little bit
                    longer.
                  </CCardText>
                </CCardBody>
                <CCardFooter>
                  <small class="text-medium-emphasis"
                    >Last updated 3 mins ago</small
                  >
                </CCardFooter>
              </CCard>
            </CCol>
            <CCol xs>
              <CCard>
                <CCardImage orientation="top" :src="VueImg" />
                <CCardBody>
                  <CCardTitle>Card title</CCardTitle>
                  <CCardText>
                    This is a wider card with supporting text below as a natural
                    lead-in to additional content. This content is a little bit
                    longer.
                  </CCardText>
                </CCardBody>
                <CCardFooter>
                  <small class="text-medium-emphasis"
                    >Last updated 3 mins ago</small
                  >
                </CCardFooter>
              </CCard>
            </CCol>
            <CCol xs>
              <CCard>
                <CCardImage orientation="top" :src="VueImg" />
                <CCardBody>
                  <CCardTitle>Card title</CCardTitle>
                  <CCardText>
                    This is a wider card with supporting text below as a natural
                    lead-in to additional content. This content is a little bit
                    longer.
                  </CCardText>
                </CCardBody>
                <CCardFooter>
                  <small class="text-medium-emphasis"
                    >Last updated 3 mins ago</small
                  >
                </CCardFooter>
              </CCard>
            </CCol>
          </CRow>
        </CCardBody>
      </CCard>
      <div class="text-center">
        <CPagination aria-label="Page navigation example">
          <CPaginationItem href="#">Previous</CPaginationItem>
          <CPaginationItem href="#">1</CPaginationItem>
          <CPaginationItem href="#">2</CPaginationItem>
          <CPaginationItem href="#">3</CPaginationItem>
          <CPaginationItem href="#">Next</CPaginationItem>
        </CPagination>
      </div>
    </CCol>
  </CRow>
</template>

<script>
import VueImg from '@/assets/images/vue.jpg'
export default {
  name: 'Products',
  setup() {
    return {
      VueImg,
    }
  },
}
</script>
