<style scoped>
.container{
  margin-top: 130px;
}
</style>
<template>
  <header-admin></header-admin>
  <div class="container">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-header">Import Products</div>

        <div class="card-body">
          <form @submit.prevent="uploadFile">
            <div class="form-group">
              <label for="csvFile">Select CSV file:</label>
              <input type="file" id="csvFile" @change="handleFileUpload" />
            </div>
            <button type="submit">Upload and Import</button>
          </form>

          <div v-if="importStatus" class="mt-3">
            <p>{{ importStatus }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      file: null,
      importStatus: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    uploadFile() {
      if (!this.file) {
        this.importStatus = "Please select a file first.";
        return;
      }

      const formData = new FormData();
      formData.append("file", this.file);

      fetch("/import-csv", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          this.importStatus = data.message;
        })
        .catch((error) => {
          console.error("Error:", error);
          this.importStatus = "Failed to upload file.";
        });
    },
  },
};
</script>
